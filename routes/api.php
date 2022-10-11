<?php

use App\Http\Controllers\payment\CheckoutPaymentController;
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

Route::get('eway/payment/response', [CheckoutPaymentController::class, 'ewayPayemntResponse']);
Route::get('paypal/payment/response', [CheckoutPaymentController::class, 'paypalPayemntResponse']);

Route::post('payment/setting', [\App\Http\Controllers\account\PaymentSettingController::class, 'createSetting']);
Route::post('payment/setting/update', [\App\Http\Controllers\account\PaymentSettingController::class, 'updatePaymentSetting']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
