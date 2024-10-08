<?php

namespace Admin\Http\Controllers\Api;

use Illuminate\Http\Request;

class LogoUpload
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $request->file('logo')->storeAs('img', 'header_logo.'.$request->file('logo')->extension());
    }
}
