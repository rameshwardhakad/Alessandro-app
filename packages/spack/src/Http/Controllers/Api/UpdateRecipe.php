<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class UpdateRecipe
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $token = option('new_version_update_token');
        Artisan::call('migrate --force');

        Cache::flush();

        $version = str_replace('.', '', option('app_updates')['version']);

        if ($version == 331) {
            $this->v332();
        }

        if ($version >= 331 && $version < 334) {
            $this->v334();
        }

        option([
            'app_updates' => [
                'update_available' => false,
                'version' => option('app_updates')['new_version'],
                'new_version' => option('app_updates')['new_version'],
                'checked_at' => option('app_updates')['checked_at'],
            ],
            'global_update_notification' => null,
            'new_version_update_token' => null,
        ]);

        Http::post('https://envato.codedot.dev/installer/api/installation/status', [
            'success' => true,
            'token' => $token,
        ]);

        return [
            'success' => true,
            'status' => 'done',
        ];
    }

    /**
     * Update Recipe.
     */
    protected function v332()
    {
        $path = base_path('.env');
        $content = file_get_contents($path);
        $changesMade = false;

        if (! str_contains($content, 'PURCHASE_CODE')) {
            $content .= "\nPURCHASE_CODE=";
            $changesMade = true;
        }

        if (! str_contains($content, 'PURCHASE_EMAIL')) {
            $content .= "\nPURCHASE_EMAIL=\n";
            $changesMade = true;
        }

        if ($changesMade) {
            file_put_contents($path, $content);
        }
    }

    /**
     * Update Recipe.
     */
    protected function v334()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('size')->nullable();
            $table->boolean('is_image')->default(false);
        });
    }
}
