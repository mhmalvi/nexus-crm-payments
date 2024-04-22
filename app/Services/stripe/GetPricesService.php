<?php

namespace App\Services\stripe;

class GetPricesService
{
    public function getPricesOfProduct($data)
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->prices->all(['product' => $data, 'active' => 'true']);
    }
}
