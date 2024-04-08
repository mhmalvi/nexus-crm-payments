<?php

namespace App\Services\stripe;

use Carbon\Carbon;
use App\Models\Company;

class UpgradeSubscriptionService
{
    public function upgradeSubscription($data)
    {
        // dd($data);
        $current_date = Carbon::now();
        // $end_date = $current_date->addDays(365);        
        $stripe = new
            \Stripe\StripeClient(config("app.stripe_secret"));
        $response = $stripe->subscriptions->update(
            $data[5],
            ['items' => [[
                'id'=>$data[6],
                'price' => $data[3]]]]
        );
        $company = Company::where('connect_id',$data[0])->first();
        $company->package = $data[2];
        $company->interval = $data[1];
        $company->end_date = $response->current_period_end;
        // $company->save();
        $company->subscription_id = $response->id;
        $company->save();
        return $response;
    }
}
