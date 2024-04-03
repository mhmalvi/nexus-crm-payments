<?php

namespace App\Http\Controllers\price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function createPrice()
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        $response = $stripe->prices->create([
            'currency' => 'aud',
            'unit_amount' => 1000,
            'recurring' => ['interval' => 'month'],
            'product_data' => ['name' => 'Gold Plan'],
        ]);
        return response()->json([
            'message'=>'inserted',
            'status'=>201,
            'data'=>$response
        ]);
    }
}
