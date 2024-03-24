<?php

namespace App\Services\stripe;

class GetCustomerTransactionsService{
    public function getCustomerTransactions($customerId){
        $stripe = new \Stripe\StripeClient(config("app.stripe_secret"));
return $stripe->charges->all(['limit' => 3,'customer'=>$customerId]);
    }
}