<?php

namespace Billing\Http\Controllers\Api;

use Illuminate\Http\Request;

class PaymentMethodController
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        try {
            $request->user()->updateDefaultPaymentMethod($request->paymentMethodId);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'pm_last_four' => $request->user()->pm_last_four,
        ];
    }
}
