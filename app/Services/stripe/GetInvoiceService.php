<?php

namespace App\Services\stripe;

class GetInvoiceService{
    public function generate_invoice($inv_id){
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->invoices->retrieve($inv_id, []);
    }
}