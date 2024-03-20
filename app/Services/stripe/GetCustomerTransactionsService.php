<?php

namespace App\Services\stripe;

class GetCustomerTransactionsService{
    public function getCustomerTransactions($customerId){
        $stripe = new \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->customers->allBalanceTransactions($customerId,['limit'=>3]);
    }
}