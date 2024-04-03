<?php

namespace App\Services\stripe;

use App\Models\Price;

class CreatePriceService
{
    public function createPrice($data)
    {
        $price =
            Price::where('client_id', $data[4])->orWhere('unit_amount', $data[1])->orWhere('interval', $data[2])->exists();
        if ($price) {
            return 422;
        } else {
            Price::create([
                'currency' => $data[0],
                'unit_amount' => $data[1],
                'recurring' => ['interval' => $data[2]],
                'product' => $data[3],
                'client_id' => $data[4]
            ]);
            $stripe = new
                \Stripe\StripeClient(config("app.stripe_secret"));
            return $stripe->prices->create([
                'currency' => $data[0],
                'unit_amount' => $data[1],
                'recurring' => ['interval' => $data[2]],
                'product' => $data[3],
                'client_id' => $data[4]
            ]);
        }
    }
}
