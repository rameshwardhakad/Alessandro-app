<?php

namespace Site\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;

class HomeController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $featureParentId = Category::whereName('Front Site Feature')->first()->id;
        $features = Category::whereParentId($featureParentId)->get();

        $faqParentId = Category::whereName('Front Site Faq')->first()->id;
        $faqs = Category::whereParentId($faqParentId)->get();

        $plans = Plan::get();

        return view('home', get_defined_vars());
    }
}
