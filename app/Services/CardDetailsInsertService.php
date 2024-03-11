<?php

namespace App\Services;

use App\Models\CardDetails;

class CardDetailsInsertService
{
    public $card_data;
    public function __construct($card_data)
    {
        $this->card_data = $card_data;
    }

    public function saveCardDetails()
    {
        $response = CardDetails::create([
            'email' => $this->card_data[0],
            'type' => $this->card_data[1],
            'name' => $this->card_data[2],
            'client_id' => $this->card_data[3],
            'user_id' => $this->card_data[4],
            'card_number' => $this->card_data[5],
            'exp_date' => $this->card_data[6],
            'cvc' => $this->card_data[7],
        ]);
        return $response;
    }
}
