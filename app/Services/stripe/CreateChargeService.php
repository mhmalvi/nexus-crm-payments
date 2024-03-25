<?php

namespace App\Services\stripe;

class CreateChargeService
{
    public function charge($data)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        $stripe->charges->create([
            'amount' => $data[0],
            'currency' => 'aud',
            'source' => $data[2],
            'customer'=>$data[1]
        ]);
    }
}
