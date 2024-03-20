<?php

namespace App\Services\stripe;

use Carbon\Carbon;

class CreateSubscriptionService
{
    public function createSubscription($customerId)
    {
        $current_date = Carbon::now();
            $end_date = $current_date->addDays(30);
        $company = Company::where('connect_id',$customerId)->first();
        $company->package = 'standard';
        $company->end_date = $end_date;
        $company->save();
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->subscriptions->create([
            'customer' => $customerId,
            'items' => [['price' => 'price_1OvZEkGeh9PhcWp49mwj2QAM']],
        ]);
    }
}
