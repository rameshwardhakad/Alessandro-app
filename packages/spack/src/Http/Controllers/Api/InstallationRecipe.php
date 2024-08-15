<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class InstallationRecipe
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $response = Http::post('https://envato.codedot.dev/installer/api/verify-token', [
            'token' => $request->token,
        ]);

        if ($response->successful()) {
            Artisan::call('key:generate');
            Artisan::call('migrate:fresh --seed --force');

            Http::post('https://envato.codedot.dev/installer/api/installation/status', [
                'success' => true,
                'token' => $request->token,
            ]);

            return [
                'success' => true,
            ];
        }

        return [
            'success' => false,
            'message' => 'We could not verify the token!',
        ];
    }
}
