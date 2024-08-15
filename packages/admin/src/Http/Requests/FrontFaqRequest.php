<?php

namespace Admin\Http\Requests;

use AhsanDev\Support\Requests\FormRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontFaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
        ];
    }

    /**
     * Database Transaction.
     */
    public function transaction(): void
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
