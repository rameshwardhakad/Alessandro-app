<?php

namespace Admin\Http\Requests;

use AhsanDev\Support\Requests\FormRequest;
use Illuminate\Support\Facades\DB;

class SettingsGeneralFrontRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'front_site_heading' => 'nullable',
            'front_site_short_description' => 'nullable',
            'front_site_copyright' => 'nullable',
        ];
    }

    /**
     * Database Transaction.
     */
    public function transaction(): void
    {
        DB::transaction(function () {
            option(
                $this->request->all()
            );
        });
    }
}
