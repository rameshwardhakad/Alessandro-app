<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;

class SettingsSocialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'social_facebook' => 'nullable',
            'social_twitter' => 'nullable',
            'social_instagram' => 'nullable',
            'social_gitHub' => 'nullable',
            'social_dribbble' => 'nullable',
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
            option(
                $this->request->all()
            );
        });
    }
}
