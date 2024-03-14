<?php

namespace App\Services;

use App\Interfaces\CardDetailsInterface;
use App\Interfaces\InsertCardDetailsInterface;
use App\Models\CardDetails;

class CardDetailsInsertService implements InsertCardDetailsInterface
{

    public function saveCardDetails($card_data)
    {
        return CardDetails::create([
            'email' => $card_data[0],
            'type' => $card_data[1],
            'name' => $card_data[2],
            'client_id' => $card_data[3],
            'user_id' => $card_data[4],
            // 'card_number' => $card_data[5],
            // 'exp_date' => $card_data[6],
            // 'cvc' => $card_data[7],
            'stripe_customer_id' => $card_data[6],
            'stripe_card_id' => $card_data[5],
        ]);
    }
}
