<?php

namespace App\Models;

use Admin\Http\Filters\SubscriptionFilters;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    /**
     * Apply all relevant filters.
     */
    public function scopeFilter($query, SubscriptionFilters $filters)
    {
        return $filters->apply($query);
    }
}
