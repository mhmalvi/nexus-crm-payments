<?php

namespace App\Services\cardDetails;

use App\Models\CardDetails;

class UpdateCardDetailsService
{
    public function updateCardDetails($card_data)
    {
        $ifCardExist = CardDetails::where('client_id', $card_data[3])->exists();
        if (!$ifCardExist) {
            return 3;
        } else {
            return CardDetails::where('client_id', $card_data[3])->update([
                // 'type'=>$card_data[]
                'card_number' => $card_data[0],
                'exp_date' => $card_data[1],
                'cvc' => $card_data[2],
                'type' => $card_data[4],
                'name' => $card_data[5],
                'email' => $card_data[6],
            ]);
        }
        return CardDetails::where('client_id', $card_data[3])->update([
            // 'type'=>$card_data[]
            'card_number' => $card_data[0],
            'exp_date' => $card_data[1],
            'cvc' => $card_data[2],
            'type' => $card_data[4],
            'name' => $card_data[5],
            'email' => $card_data[6],
        ]);
    }
}
