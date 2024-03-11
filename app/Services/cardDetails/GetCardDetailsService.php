<?php

namespace App\Services\cardDetails;

use App\Models\CardDetails;

class GetCardDetailsService
{
    public $client_id;
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getCardDetails()
    {
        $response = CardDetails::where('client_id', $this->client_id)->first();
        return $response;
    }
}
