<?php

namespace App\Http\Controllers\payment;

use App\Models\CardDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyCardRequest;
use App\Services\CardDetailsInsertService;
use App\Http\Requests\GetCardDetailsRequest;
use App\Http\Requests\CardDetailsInsertRequest;
use App\Http\Requests\UpdateCardDetailsRequest;
use App\Interfaces\CardDetailsInterface;
use App\Interfaces\InsertCardDetailsInterface;
use App\Services\cardDetails\DestroyCardService;
use App\Services\cardDetails\GetCardDetailsService;
use App\Services\cardDetails\UpdateCardDetailsService;

class CardDetailsController extends Controller
{
    private $updateCardDetailsService;
    private $destroyCardService;
    public function __construct(UpdateCardDetailsService $updateCardDetailsService, DestroyCardService
    $destroyCardService)
    {
        $this->updateCardDetailsService = $updateCardDetailsService;
        $this->destroyCardService = $destroyCardService;
    }
    public function insertCardDetails(CardDetailsInsertRequest $request, InsertCardDetailsInterface $insertCardDetails)
    {
        $card_data = [
            $email = $request->data['email'],
            $type = $request->data['type'],
            $name = $request->data['name'],
            $client_id = $request->data['client_id'],
            $user_id = $request->data['user_id'],
            $card_number = $request->data['card_number'],
            $exp_date = $request->data['exp_date'],
            $cvc = $request->data['cvc'],
        ];
        $response = $insertCardDetails->saveCardDetails($card_data);
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

    public function getCardDetails(GetCardDetailsRequest $request, CardDetailsInterface $cardDetails)
    {
        $result = $cardDetails->getCardDetails($request->client_id);
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

    public function destroyCard(DestroyCardRequest $request)
    {
        $response = $this->destroyCardService->destroyCard($request->card_id);
        if ($response) {
            return response()->json([
                'message' => 'Deleted',
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 500
            ], 500);
        }
    }
}
