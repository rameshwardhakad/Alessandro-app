<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Requests\SettingsSocialFrontRequest;
use AhsanDev\Support\Field;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class SettingsSocialFrontController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return ['can:setting'];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Field::make()
                ->field('social_facebook', option('social_facebook'))
                ->field('social_twitter', option('social_twitter'))
                ->field('social_instagram', option('social_instagram'))
                ->field('social_gitHub', option('social_gitHub'))
                ->field('social_dribbble', option('social_dribbble'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return new SettingsSocialFrontRequest($request);
    }
}
