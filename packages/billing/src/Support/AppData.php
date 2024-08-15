<?php

namespace Billing\Support;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use JsonSerializable;
use Laranext\Span\Span;

class AppData implements JsonSerializable
{
    protected $data = [];

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Prepare data.
     */
    protected function handle(): void
    {
        $user = auth()->user();
        $subscription = $user->subscriptions()->active()->first();

        $this->data = [
            'csrf_token' => csrf_token(),
            'prefix' => Span::prefix(),
            'is_super_admin' => Auth::user()->isSuperAdmin(),
            'header_logo' => option('app_logo'),
            'app_name' => env('APP_NAME', 'Spack'),
            'locale' => option('app_locale', 'en'),
            'translations' => json_decode(file_get_contents(base_path('packages/billing/lang/'.option('app_locale', 'en').'.json')), true),
            'permissions' => [],
            'user' => Auth::user()->only(['id', 'name', 'email', 'avatar', 'pm_last_four']),
            'plans' => Plan::get(),
            'invoices' => $this->getInvoices(),
            'trial_days' => option('trial_days'),
            'STRIPE_KEY' => env('STRIPE_KEY'),
            'client_secret' => env('STRIPE_SECRET') ? $user->createSetupIntent()->client_secret : null,
            'cardLastFour' => $user->pm_last_four,
            'isSubscribed' => $subscription ? $subscription->only(['type']) : null,
            'onGracePeriod' => $subscription ? $subscription->onGracePeriod() : false,
            'subscribePlan' => request('subscribe'),
        ];
    }

    /**
     * Prepare invoices.
     */
    public function getInvoices(): array
    {
        $invoices = [];

        // Cache::remember('user:' . auth()->id() . ':invoices', $seconds, function () {
        //     return DB::table('users')->get();
        // });

        foreach (auth()->user()->invoices() as $invoice) {
            $invoices[] = [
                'id' => $invoice->id,
                'date' => $invoice->date()->toFormattedDateString(),
                'total' => $invoice->total(),
            ];
        }

        return $invoices;
    }

    /**
     * Prepare the field for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
