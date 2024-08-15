<?php

namespace Spack\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Facades\Spack\Static\Color;

class ColorOption extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Color::options();
    }
}
