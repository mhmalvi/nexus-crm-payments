<?php

namespace App\Services\cardDetails;

use App\Models\CardDetails;

class DestroyCardService{
    public function destroyCard($cardId){
        $response = CardDetails::find($cardId);
        return $response->delete();
    }
}