<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;

class SettingsFrontGeneralRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'front_site_heading' => 'nullable',
            'front_site_short_description' => 'nullable',
            'front_site_copyright' => 'nullable',
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
