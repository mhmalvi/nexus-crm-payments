<?php

namespace App\Services\stripe;

class CreateSubscriptionService
{
    public function createSubscription($customerId)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->subscriptions->create([
            'customer' => $customerId,
            'items' => [['price' => 'price_1OvZEkGeh9PhcWp49mwj2QAM']],
        ]);
    }
}
