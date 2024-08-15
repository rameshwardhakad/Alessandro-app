<?php

namespace Admin\Http\Controllers\Api;

use Illuminate\Http\Request;

class FrontLogoUpload
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $request->file('logo')->storeAs('img', 'front_site_logo.'.$request->file('logo')->extension());
    }
}
