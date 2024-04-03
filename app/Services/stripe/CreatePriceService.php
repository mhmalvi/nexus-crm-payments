<?php

namespace App\Services\stripe;

use App\Models\Price;

class CreatePriceService
{
    public function createPrice($data)
    {
        Price::create([
            'unit_amount' => $data[1],
            'interval' => $data[2],
            'prod_id' => $data[3]
        ]);
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->prices->create([
            'currency' => $data[0],
            'unit_amount' => $data[1],
            'recurring' => ['interval' => $data[2]],
            'product' => $data[3]
        ]);
    }
}
