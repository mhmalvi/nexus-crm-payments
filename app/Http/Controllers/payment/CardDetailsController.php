<?php

namespace App\Http\Controllers\payment;

use App\Models\CardDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CardDetailsInsertService;
use App\Http\Requests\GetCardDetailsRequest;
use App\Http\Requests\CardDetailsInsertRequest;
use App\Http\Requests\UpdateCardDetailsRequest;
use App\Services\cardDetails\GetCardDetailsService;
use App\Services\cardDetails\UpdateCardDetailsService;

class CardDetailsController extends Controller
{
    private $updateCardDetailsService;
    public function __construct(UpdateCardDetailsService $updateCardDetailsService)
    {
        $this->updateCardDetailsService = $updateCardDetailsService;
    }
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

    public function updateCardDetails(Request $request)
    {
        // dd($request->cvc);
        $card_data = [
            $card_number = $request->card_number,
            $exp_date = $request->exp_date,
            $cvc = $request->cvc,
            $client_id = $request->client_id,
            $type = $request->type,
            $name = $request->name,
            $email = $request->email,
        ];
        $result = $this->updateCardDetailsService->updateCardDetails($card_data);
        if ($result == 1) {
            return response()->json([
                'message' => 'Updated',
                'status' => 201,
            ], 201);
        } else if ($result == 3) {
            return response()->json([
                'message' => 'No data found',
                'status' => 404,
            ], 404);
        }
    }
}
