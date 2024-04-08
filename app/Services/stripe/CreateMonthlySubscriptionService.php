<?php

namespace App\Services\stripe;

use Carbon\Carbon;
use App\Models\Company;
use App\Interfaces\CreateSubscriptionInterface;

class CreateMonthlySubscriptionService
{
    public function createSubscription($data)
    {
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        $response = $stripe->subscriptions->create([
        'customer' => $data[0],

        'items' => [['price' => $data[3]]],
        ]);
        dd($response->current_period_end);
        $current_date = Carbon::now();
            $end_date = $current_date->addDays(1);            
        $company = Company::where('connect_id',$data[0])->first();
        $company->active = $data[4];
        $company->package = $data[2];
        $company->interval = $data[1];
        $company->end_date = $end_date;
        $company->save();
        
        // dd($response);
        $company->subscription_id = $response->id;
        $company->save();
        return $response;
    }
}
