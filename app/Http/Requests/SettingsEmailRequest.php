<?php

namespace App\Http\Requests;

use App\Support\UpdateEnvConfig;
use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;
use Symfony\Component\Mailer\Transport;

class SettingsEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mail_driver' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'nullable',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',
        ];
    }

    /**
     * Get the laravel app configs to change.
     *
     * @return array
     */
    public function configs()
    {
        return [
            'MAIL_DRIVER' => 'mail_driver',
            'MAIL_HOST' => 'mail_host',
            'MAIL_PORT' => 'mail_port',
            'MAIL_USERNAME' => 'mail_username',
            'MAIL_PASSWORD' => 'mail_password',
            'MAIL_ENCRYPTION' => 'mail_encryption',
            'MAIL_FROM_ADDRESS' => 'mail_from_address',
            'MAIL_FROM_NAME' => 'mail_from_name',
        ];
    }

    /**
     * Database Transaction.
     *
     * @return void
     */
    public function transaction()
    {
        $dsn = "smtp://{$this->request->mail_username}:{$this->request->mail_password}@{$this->request->mail_host}:{$this->request->mail_port}";
        $transport = Transport::fromDsn($dsn);
        $transport->getStream()->setTimeout(1.0);

        try {
            $transport->getStream()->initialize();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);

            return $e->getMessage();
        }

        DB::transaction(function () {
            new UpdateEnvConfig($this->request, $this->configs());

            option(
                $this->request->all()
            );

            option(['email_config' => true]);
        });
    }
}
