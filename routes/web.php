<?php

use App\Http\Controllers\payment\CheckoutPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\payway\PaywayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('trialPeriod');
// });
Route::get('/upgrade', function () {
return view('subcriptionUpgrade');
});
Route::get('/payway', [PaywayController::class, 'payway']);
Route::get('/checkout', [CheckoutPaymentController::class, 'checkout']);
Route::get('payment/success', [CheckoutPaymentController::class, 'success'])->name('success');
Route::get('payment/fail', [CheckoutPaymentController::class, 'success'])->name('fail');
