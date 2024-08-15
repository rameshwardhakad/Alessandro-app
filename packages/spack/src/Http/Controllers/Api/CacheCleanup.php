<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Support\Facades\Cache;

class CacheCleanup
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        Cache::flush();

        return 'Done!';
    }
}
