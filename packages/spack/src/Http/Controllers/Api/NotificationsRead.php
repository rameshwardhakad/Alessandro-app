<?php

namespace Spack\Http\Controllers\Api;

class NotificationsRead
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return [
            'success' => true,
        ];
    }
}
