<?php

namespace App\Http\Controllers\subscription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\stripe\GetAllSubscription;


class SubscriptionController extends Controller
{
    private $getAllSubscriptions;
    public function __construct(GetAllSubscription $getAllSubscriptions)
    {
        $this->getAllSubscriptions = $getAllSubscriptions;
    }
    public function getAllSubscriptions()
    {
        $response = $this->getAllSubscriptions->getSubscriptions();
//         $stripe = new \Stripe\StripeClient(config("app.stripe_secret"));
// $response= $stripe->subscriptions->all(['limit' => 3]);
// $response = 
        // dd(json_decode($response));
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => json_decode($response)
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }
}
