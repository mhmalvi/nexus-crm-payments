<?php

namespace App\Interfaces;

interface StripeInterface{
    public function stripeCardCreate($card_data);
    public function stripeRead($data);
}