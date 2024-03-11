<?php

namespace App\Http\Controllers\payment;

use App\Models\CardDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CardDetailsInsertService;
use App\Http\Requests\GetCardDetailsRequest;
use App\Http\Requests\CardDetailsInsertRequest;
use App\Services\cardDetails\GetCardDetailsService;

class CardDetailsController extends Controller
{
    public function insertCardDetails(CardDetailsInsertRequest $request)
    {
        $card_data = [
            $email = $request->email,
            $type = $request->type,
            $name = $request->name,
            $client_id = $request->client_id,
            $user_id = $request->user_id,
            $card_number = $request->card_number,
            $exp_date = $request->exp_date,
            $cvc = $request->cvc,
        ];
        $cardDetailsInsertService = new CardDetailsInsertService($card_data);
        $response = $cardDetailsInsertService->saveCardDetails();
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 201,
                'data' => $response
            ], 201);
        } else {
            return response()->json([
                'message' => 'success',
                'status' => 201,
                'data' => $response
            ], 500);
        }
    }

    public function getCardDetails(GetCardDetailsRequest $request)
    {
        $getCardDetailsService = new GetCardDetailsService($request->client_id);
        $result = $getCardDetailsService->getCardDetails();
        if ($result) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $result
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }
}
