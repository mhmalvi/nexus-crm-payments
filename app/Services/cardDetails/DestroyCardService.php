<?php

namespace App\Services\cardDetails;

use App\Models\CardDetails;

class DestroyCardService{
    public function destroyCard($data){
        $response = CardDetails::where('id',$data[0])->where('client_id',$data[1]);
        if($response){
             return $response->delete();
        }        
    }
}