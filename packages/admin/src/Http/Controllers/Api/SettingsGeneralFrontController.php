<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Requests\SettingsGeneralFrontRequest;
use AhsanDev\Support\Field;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class SettingsGeneralFrontController implements HasMiddleware
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Field::make()
                ->field('front_site_logo', option('front_site_logo'))
                ->field('front_site_heading', option('front_site_heading'))
                ->field('front_site_short_description', option('front_site_short_description'))
                ->field('front_site_copyright', option('front_site_copyright'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return new SettingsGeneralFrontRequest($request);
    }
}
