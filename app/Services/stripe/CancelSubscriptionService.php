<?php

namespace App\Services\stripe;

class CancelSubscription{
    public function cancelSubscription($data){
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        $stripe->subscriptions->cancel($data, []);
    }
}