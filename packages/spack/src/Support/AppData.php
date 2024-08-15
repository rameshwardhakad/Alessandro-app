<?php

namespace Spack\Support;

use Illuminate\Support\Facades\Auth;
use JsonSerializable;
use Laranext\Span\Span;

class AppData implements JsonSerializable
{
    protected $data = [];

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Prepare data.
     */
    protected function handle(): void
    {
        $this->data = [
            'csrf_token' => csrf_token(),
            'prefix' => Span::prefix(),
            'is_super_admin' => Auth::user()->isSuperAdmin(),
            'header_logo' => option('app_logo'),
            'app_name' => env('APP_NAME', 'Spack'),
            'translations' => json_decode(file_get_contents(base_path('packages/spack/lang/'.option('app_locale', 'en').'.json')), true),
            'permissions' => auth()->user()->allPermissions(),
            'user' => Auth::user()->only(['id', 'name', 'email', 'avatar']),
            'sidebar_projects' => new SidebarProject,
            'is_standalone_demo' => $this->isStandaloneDemo(),
            'app_updates' => option('app_updates'),
            'purchase_code' => env('PURCHASE_CODE'),
            'purchase_email' => env('PURCHASE_EMAIL'),
        ];
    }

    protected function isStandaloneDemo()
    {
        if (request()->getHttpHost() == 'localhost') {
            return false;
        }

        $host = explode('.', request()->getHttpHost());

        if (isset($host[1]) && $host[1] == 'spackdemo') {
            return true;
        }

        return false;
    }

    /**
     * Prepare the field for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
