<?php

namespace App\Services\stripe;

use Carbon\Carbon;
use App\Models\Company;
use App\Interfaces\CreateSubscriptionInterface;

class CreateMonthlySubscriptionService
{
    public function createSubscription($data)
    {
        $current_date = Carbon::now();
            $end_date = $current_date->addDays(30);
        $company = Company::where('connect_id',$data[0])->first();
        $company->package = $data[2].'_'.$data[1];
        $company->end_date = $end_date;
        $company->save();
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        $response = $stripe->subscriptions->create([
            'customer' => $data[0],

            'items' => [['price' => $data[3]]],
        ]);
        $company->subscription_id = $response->data->id;
        $company->save();
        return $response;
    }
}
