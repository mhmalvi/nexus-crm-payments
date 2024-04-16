<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\payment\CardDetailsController;
use App\Http\Controllers\payment\CheckoutPaymentController;
use App\Http\Controllers\payment\InvoiceController;
use App\Http\Controllers\payment\MakePaymentController;
use App\Http\Controllers\payment\PaymentHistoryController;
use App\Http\Controllers\price\PriceController;
use App\Http\Controllers\transaction\TransactionController;
use App\Http\Controllers\subscription\SubscriptionController;
use App\Http\Controllers\products\ProductController;

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
    Route::post('create-subscriptions', [SubscriptionController::class, 'create_subscription']);
    Route::post('get-customer-transactions', [PaymentHistoryController::class, 'index']);
});

Route::group(['middleware' => 'superAdminAndAdminAuthentication'], function () {

    
});
Route::group(['middleware' => 'SuperAdminAuthentication'], function () {

    Route::post('create-prices', [PriceController::class, 'createPrice']);
    Route::get('subscriptions', [SubscriptionController::class, 'getAllSubscriptions']);
});

// Route::get('get-invoice',[InvoiceController::class,'generatePDF']);

// Route::post('trial-check', [SubscriptionController::class, 'trialCheck']);
Route::post('charge', [MakePaymentController::class, 'makePayment']);

Route::post('prices', [PriceController::class, 'getPrices']);
// Route::post('prices', [PriceController::class, 'getPrices']);