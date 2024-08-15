<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Requests\SettingsStripeRequest;
use AhsanDev\Support\Field;
use Illuminate\Http\Request;

class SettingsStripeController
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Field::make()
                ->field('stripe_key', env('STRIPE_KEY'))
                ->field('stripe_secret', env('STRIPE_SECRET') ? 'it is a secret key so we could not show you there.' : null)
                ->field('stripe_webhook_secret', env('STRIPE_WEBHOOK_SECRET'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return new SettingsStripeRequest($request);
    }
}
