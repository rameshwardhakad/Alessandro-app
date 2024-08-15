<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;
use App\Notifications\ProjectAssigned;
use Illuminate\Support\Facades\Notification;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:190',
            'description' => 'nullable',
            'started_at' => 'nullable',
            'due_at' => 'nullable',
            'color_id' => 'required',
            'member_type' => 'required',
            'users' => 'exclude_unless:member_type,team_members|required|array',
            'teams' => 'exclude_unless:member_type,teams|required|array',
        ];
    }

    /**
     * Get custom attributes.
     *
     * @return array
     */
    public function customAttributes()
    {
        return [
            'color_id' => 'category',
        ];
    }

    /**
     * Database Transaction.
     *
     * @return void
     */
    public function transaction()
    {
        DB::transaction(function () {
            $this->attributes['meta'] = [
                'member_type' => $this->request->member_type,
                'teams' => $this->request->teams ?? [],
            ];
            $this->attributes['status_id'] = Status::getId('Ongoing');

            unset($this->attributes['member_type']);
            unset($this->attributes['teams']);
            unset($this->attributes['users']);

            $this->model->forceFill($this->attributes);
            $this->model->save();

            if ($this->request->member_type == 'only_me') {
                $this->model->users()->sync(auth()->id());
            } elseif ($this->request->member_type == 'everyone') {
                $this->model->users()->sync(User::pluck('id'));
            } elseif ($this->request->member_type == 'team_members') {
                $this->model->users()->sync($this->request->users);
            } elseif ($this->request->member_type == 'teams') {
                $users = DB::table('team_user')->whereIn('team_id', $this->request->teams)->pluck('user_id');
                $this->model->users()->sync($users);
            }

            if ($this->isPostRequest) {
                Notification::send($this->model->users, new ProjectAssigned($this->model));
            }
        });
    }
}
