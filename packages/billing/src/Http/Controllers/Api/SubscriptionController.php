<?php

namespace Billing\Http\Controllers\Api;

use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $stripePlanId = Plan::whereName($request->plan)->first();

        try {
            $request->user()->newSubscription(
                $request->plan, $stripePlanId->meta['stripe_plan_id']
            )->create($request->paymentMethodId);
        } catch (IncompletePayment $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'payment_id' => $e->payment->id,
                'redirect' => '/app',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }

        return [
            'success' => true
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function cancel()
    {
        auth()->user()->subscriptions()->active()->first()->cancel();

        return [
            'success' => true
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function resume()
    {
        auth()->user()->subscriptions()->active()->onGracePeriod()->first()->resume();

        return [
            'success' => true
        ];
    }
}
