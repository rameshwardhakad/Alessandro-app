<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Billing\Http\Controllers\Api\SubscriptionController;
use Billing\Http\Controllers\Api\PaymentMethodController;

Route::get('subscription', [SubscriptionController::class, 'store']);
Route::post('subscription', [SubscriptionController::class, 'store']);
Route::post('subscription/cancel', [SubscriptionController::class, 'cancel']);
Route::post('subscription/resume', [SubscriptionController::class, 'resume']);
Route::post('payment-method', [PaymentMethodController::class, 'store']);

Route::get('/user/invoice/{invoice}', function (Request $request, $invoiceId) {
    return $request->user()->downloadInvoice($invoiceId, [
        'vendor' => env('APP_NAME'),
        'product' => 'Your Product',
    ]);
});
