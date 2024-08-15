<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Filters\CustomerFilters;
use App\Models\User;

class CustomerController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerFilters $filters)
    {
        return User::withoutGlobalScope('App\Support\TenantableScope')
            ->where('is_customer', true)
            ->with(['subscriptions' => function ($q) {
                $q->active();
            }])
            ->customerFilter($filters)
            ->simplePaginate()
            ->through(function ($item) {
                return [
                    'name' => $item->name,
                    'email' => $item->email,
                    'avatar' => $item->avatar,
                    'created_at' => $item->created_at ? $item->created_at->format('M d, Y') : null,
                    'subscription' => $item->subscriptions->first() ? $item->subscriptions->first()->type : null,
                ];
            });
    }
}
