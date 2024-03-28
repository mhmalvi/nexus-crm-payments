<?php

namespace App\Services\stripe;

class UpgradeSubscriptionService
{
    public function upgradeSubscription($data)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->subscriptions->update(
            $data[5],
            ['items' => ['price' => $data[3]]]
        );
    }
}
