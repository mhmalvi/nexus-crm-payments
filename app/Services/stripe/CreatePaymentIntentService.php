<?php

namespace App\Services\stripe;

class CreatePaymentIntentService{
    public function createPaymentIntent(){
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        $stripe->paymentIntents->create([
        'amount' => 2000,
        'currency' => 'usd',
        'automatic_payment_methods' => ['enabled' => true],
        ]);
    }
}