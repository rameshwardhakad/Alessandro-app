<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Filters\SubscriptionFilters;
use App\Models\Subscription;

class SubscriptionController
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionFilters $filters)
    {
        $subscriptions = Subscription::withoutGlobalScope('App\Support\TenantableScope')
            ->with(['user' => function ($q) {
                $q->withoutGlobalScope('App\Support\TenantableScope');
            }])
            ->filter($filters)
            ->simplePaginate();

        return $subscriptions->through(function ($item) {
            return [
                'name' => $item->type,
                'status' => $item->stripe_status,
                'user' => [
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'avatar' => $item->user->avatar,
                ],
            ];
        });
    }
}
