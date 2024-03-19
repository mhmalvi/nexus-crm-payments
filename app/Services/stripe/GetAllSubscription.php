<?php

namespace App\Services\stripe;
use Illuminate\Support\Facades\Http;

class GetAllSubscription{
    public function getSubscriptions(){
        // dd(config("app.stripe_secret"));
        return HTTP::withHeaders([
            'Authorization' => 'Bearer ' . config("app.stripe_secret"),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->get("https://api.stripe.com/v1/subscriptions");
    }
}