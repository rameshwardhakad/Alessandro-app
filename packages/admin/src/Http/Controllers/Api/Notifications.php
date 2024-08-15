<?php

namespace Admin\Http\Controllers\Api;

class Notifications
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;

        return [
            'new' => $notifications->whereNull('read_at')->count(),
            'notifications' => $notifications->whereNull('read_at'),
        ];
    }
}
