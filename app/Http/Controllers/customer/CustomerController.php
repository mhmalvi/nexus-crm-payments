<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\stripe\GetAllSubscription;

class CustomerController extends Controller
{
    public function create_subscription(Request $request)
    {
    }

    public function getAllSubscription(GetAllSubscription $subscriptions)
    {
        $response = $subscriptions->getSubscriptions();
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }
}
