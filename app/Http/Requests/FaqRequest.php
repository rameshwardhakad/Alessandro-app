<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;

class FaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
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
            $parentId = Category::whereName('Front Site Faq')->first()->id;

            $this->model->forceFill([
                'parent_id' => $parentId,
                'name' => $this->attributes['title'],
                'key' => $this->attributes['title'],
                'slug' => Str::slug($this->attributes['title']),
                'meta' => [
                    'description' => $this->attributes['description'],
                ],
            ]);

            $this->model->save();
        });
    }
}
