<?php

namespace App\Http\Requests;

use App\Support\UpdateEnvConfig;
use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;

class SettingsGeneralRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_locale' => 'required',
            'app_timezone' => 'required',
            'app_direction' => 'required',
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
