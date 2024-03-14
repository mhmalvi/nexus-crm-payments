<?php

namespace App\Services\stripe;

use App\Interfaces\StripeInterface;

class StripeCustomerService implements StripeInterface
{
    public function stripeCardCreate($card_data)
    {
        // dd(config("app.stripe_secret"));
        $stripe = new \Stripe\StripeClient(config("app.stripe_secret"));
        return $stripe->customers->create([
            'name' => $card_data[2],
            'email' => $card_data[0],
        ]);
    }

    public function stripeRead($data){
//         $stripe =  new \Stripe\StripeClient(config("app.stripe_secret"));
// return $stripe->customers->all(['email'=>$data[1]]);
$stripe = new \Stripe\StripeClient("app.stripe_secret");
$stripe->customers->createSource('cus_9s6XGDTHzA66Po', ['source' => 'tok_visa']);
    }

}
