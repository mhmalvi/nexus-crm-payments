<?php

namespace App\Services\stripe;

class UpgradeSubscriptionService
{
    public function upgradeSubscription($data)
    {
        // dd($data);
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->subscriptions->update(
            $data[5],
            ['items' => [[
                'id'=>$data[5],
                'price' => $data[3]]],]
        );
    }
}
