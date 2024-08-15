<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;

class Metrics
{
    public function __invoke(): array
    {
        if (Auth::user()->isSuperAdmin()) {
            return [
                'active_subscriptions' => Subscription::query()->active()->count(),
                'incomplete_subscriptions' => Subscription::query()->incomplete()->count(),
                'total_customers' => User::whereNotNull('stripe_id')->count(),
                'total_plans' => Plan::count(),
            ];
        }
    }
}
