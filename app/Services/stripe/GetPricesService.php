<?php

namespace App\Services\stripe;

class GetPricesService
{
    public function getPrices($data)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->prices->all(['limit' => 3, 'product' => $data]);
    }
}
