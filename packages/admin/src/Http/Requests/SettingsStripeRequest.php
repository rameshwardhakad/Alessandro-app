<?php

namespace Admin\Http\Requests;

use AhsanDev\Support\Requests\FormRequest;
use AhsanDev\Support\UpdateEnvConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingsStripeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'stripe_key' => 'required',
            'stripe_secret' => 'required',
            'stripe_webhook_secret' => 'nullable',
        ];
    }

    /**
     * Database Transaction.
     */
    public function transaction(): void
    {
        DB::transaction(function () {
            $configs = [
                'STRIPE_KEY' => 'stripe_key',
                'STRIPE_SECRET' => 'stripe_secret',
                'STRIPE_WEBHOOK_SECRET' => 'stripe_webhook_secret',
            ];

            if (!Str::startsWith($this->request->stripe_secret, 'sk_')) {
                unset($configs['STRIPE_SECRET']);
            }

            new UpdateEnvConfig($this->request, $configs);
        });
    }
}
