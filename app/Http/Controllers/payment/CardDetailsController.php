<?php

namespace App\Http\Controllers\payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CardDetailsInsertService;
use App\Http\Requests\CardDetailsInsertRequest;

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
}
