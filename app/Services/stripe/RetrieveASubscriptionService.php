<?php

namespace App\Services\stripe;

class RetrieveASubscriptionService{
    public function retrieveSubscription($data){
        // dd($data);
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->subscriptions->retrieve($data, []);
    }
}