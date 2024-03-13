<?php

namespace App\Interfaces;

interface StripeInterface{
    public function stripeCreate($card_data);
    public function stripeRead($data);
}