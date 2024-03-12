<?php

namespace App\Services\cardDetails;

use App\Models\CardDetails;
use App\Interfaces\CardDetailsInterface;

class GetCardDetailsService implements CardDetailsInterface
{

    public function getCardDetails($client_id)
    {
        $response = CardDetails::where('client_id', $client_id)->first();
        return $response;
    }
}
