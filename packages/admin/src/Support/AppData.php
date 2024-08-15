<?php

namespace Admin\Support;

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
            'app_name' => env('APP_NAME', 'Ticket'),
            'translations' => json_decode(file_get_contents(base_path('packages/admin/lang/'.option('app_locale', 'en').'.json')), true),
            'permissions' => [],
            'user' => Auth::user()->only(['id', 'name', 'email', 'avatar']),
            'app_updates' => option('app_updates'),
            'purchase_code' => env('PURCHASE_CODE'),
            'purchase_email' => env('PURCHASE_EMAIL'),
        ];
    }

    /**
     * Prepare the field for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
