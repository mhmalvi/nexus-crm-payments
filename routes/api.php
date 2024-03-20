<?php

use App\Http\Controllers\payment\CardDetailsController;
use App\Http\Controllers\payment\CheckoutPaymentController;
use App\Http\Controllers\subscription\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('eway/payment/response', [CheckoutPaymentController::class, 'ewayPayemntResponse']);
Route::post('paypal/payment/response', [CheckoutPaymentController::class, 'paypalPayemntResponse']);
Route::post('payment/list', [CheckoutPaymentController::class, 'getPaymentHistories']);
Route::post('invoice/list', [CheckoutPaymentController::class, 'getInvoiceHistories']);
Route::get('payment/{lead_id}/details', [CheckoutPaymentController::class, 'getPaymentHistoriesByLead']);
Route::get('payment-details/{lead_id}', [CheckoutPaymentController::class, 'payment_details']);
Route::post('stripe', [CheckoutPaymentController::class, 'stripePost']);
Route::post('campaign-wise-payment', [CheckoutPaymentController::class, 'campaign_wise_payment']);
Route::post('monthly-payment', [CheckoutPaymentController::class, 'monthlyPayment']);
Route::post('last-week-payment', [CheckoutPaymentController::class, 'weekly_payment']);

Route::post('payment/setting/create', [\App\Http\Controllers\account\PaymentSettingController::class, 'createSetting']);
Route::put('payment/setting/{id}/update', [\App\Http\Controllers\account\PaymentSettingController::class, 'updatePaymentSetting']);
Route::post('store-payment-history', [\App\Http\Controllers\payment\PaymentHistoryController::class, 'store']);
Route::get('payment-history-delete/{id}', [\App\Http\Controllers\payment\PaymentHistoryController::class, 'destroy']);



//
Route::group(['middleware' => 'companyAuthentication'], function () {
    
    Route::post('card-details-save', [CardDetailsController::class, 'insertCardDetails']);
    Route::post('card-details', [CardDetailsController::class, 'getCardDetails']);
    Route::put('card-details-update', [CardDetailsController::class, 'updateCardDetails']);    
    Route::post('card-destroy', [CardDetailsController::class, 'destroyCard']);
});
Route::get('subscriptions', [SubscriptionController::class, 'getAllSubscriptions']);
Route::post('create-subscriptions', [SubscriptionController::class, 'create_subscription']);