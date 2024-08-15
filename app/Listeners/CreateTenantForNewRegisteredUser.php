<?php

namespace App\Listeners;

use App\Models\Tenant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class CreateTenantForNewRegisteredUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $tenant = Tenant::create([
            'name' => $event->user->email,
        ]);

        DB::table('users')
            ->whereId($event->user->id)
            ->update([
                'tenant_id' => $tenant->id,
            ]);
    }
}
