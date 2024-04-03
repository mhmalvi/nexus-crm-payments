<?php

namespace App\Services\stripe;

class GetProductsWithPricesService
{
    public function getProductsAndPrices()
    {
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        $prods = $stripe->products->all(['limit' => 3]);
        // dd
    }
}
