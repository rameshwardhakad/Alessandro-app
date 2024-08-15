<?php

namespace Admin\Http\Controllers\Api;

use AhsanDev\Support\UpdateEnvConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CheckUpdates
{
    protected $token;

    protected $new_version;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'purchase_code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $response = Http::withHeaders(['Accept' => 'application/json'])
                        ->post('https://envato.codedot.dev/installer/api/verify-update', [
                            'item' => 'spack-saas',
                            'purchase_code' => $value,
                            'current_version' => option('app_updates')['version'],
                            'domain' => request('domain'),
                            'url' => request('url'),
                        ]);

                    if (! $response->json()['success']) {
                        $fail($response->json()['error']);
                    } elseif ($response->json()['success']) {
                        $this->token = $response->json()['token'];
                        $this->new_version = $response->json()['new_version'];
                    }
                },
            ],
        ]);

        if ($this->token) {
            $contents = file_get_contents('https://envato.codedot.dev/installer/api/download-spack-update?token='.$this->token.'&item=spack-saas');
            Storage::disk('root')->put('files.zip', $contents);
        }

        option([
            'app_updates' => [
                'update_available' => $this->new_version ? true : false,
                'version' => option('app_updates')['version'],
                'new_version' => $this->new_version,
                'checked_at' => now()->format('F j, Y h:m:i A'),
            ],
        ]);

        option(['new_version_update_token' => $this->token]);

        new UpdateEnvConfig($request, ['PURCHASE_CODE' => 'purchase_code']);

        return option('app_updates');
    }
}
