<?php

namespace App\Services\stripe;

class CancelSubscriptionService{
    public function cancelSubscription($data){
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        $stripe->subscriptions->cancel($data, []);
    }
}