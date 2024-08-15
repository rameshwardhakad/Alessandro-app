<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;

class FileUpload
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $request->file('file')->store('files');
    }
}
