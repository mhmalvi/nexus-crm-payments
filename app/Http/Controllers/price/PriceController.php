<?php

namespace App\Http\Controllers\price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function createPrice(Request $request)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        $response = $stripe->prices->create([
            'currency' => $request->currency,
            'unit_amount' => $request->unit_amount,
            'recurring' => ['interval' => $request->interval],
            'product' => $request->prod_id,
        ]);
        return response()->json([
            'message'=>'inserted',
            'status'=>201,
            'data'=>$response
        ]);
    }
}
