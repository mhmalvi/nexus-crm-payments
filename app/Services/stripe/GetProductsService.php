<?php

namespace App\Services\stripe;

class GetProductsService
{
    public function getProducts()
    {
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->products->all(['limit' => 3]);
        // dd
    }
}
