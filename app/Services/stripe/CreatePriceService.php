<?php

namespace App\Services\stripe;

class CreatePriceService
{
    public function createPrice($data)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->prices->create([
            'currency' => $data[0],
            'unit_amount' => $data[1],
            'recurring' => ['interval' => $data[2]],
            'product' => $data[3],
        ]);
    }
}
