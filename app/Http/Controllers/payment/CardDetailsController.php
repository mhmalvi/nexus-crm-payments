<?php

namespace App\Http\Controllers\payment;

use App\Models\Company;
use App\Models\CardDetails;
use Illuminate\Http\Request;
use App\Interfaces\StripeInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Interfaces\CardDetailsInterface;
use App\Http\Requests\DestroyCardRequest;
use App\Services\CardDetailsInsertService;
use App\Http\Requests\GetCardDetailsRequest;
use App\Interfaces\InsertCardDetailsInterface;
use App\Http\Requests\CardDetailsInsertRequest;
use App\Http\Requests\UpdateCardDetailsRequest;
use App\Services\cardDetails\DestroyCardService;
use App\Services\cardDetails\GetCardDetailsService;
use App\Services\cardDetails\UpdateCardDetailsService;

class CardDetailsController extends Controller
{
    private $updateCardDetailsService;
    public function __construct(UpdateCardDetailsService $updateCardDetailsService)
    {
        $this->updateCardDetailsService = $updateCardDetailsService;
    }
    public function insertCardDetails(CardDetailsInsertRequest $request, InsertCardDetailsInterface $insertCardDetails, StripeInterface $stripeDetails)
    {
        // dd($request->all());
        $card_data = [
            $email = $request->email,
            $type = $request->type,
            $name = $request->name,
            $client_id = $request->client_id,
            $user_id = $request->user_id,
            $card_token = $request->tokenStripe,
            // $card_number = $request->card_number,
            // $exp_date = $request->exp_date,
            // $cvc = $request->cvc,
        ];
        // dd($card_data);
        $company = Company::where('id', $card_data[3])->where('admin', $card_data[4])->first();
        if ($company) {
            array_push($card_data, $company->connect_id);
        }
        // $stripe_response = $stripeDetails->stripeCardCreate($card_data);
        // dd($stripe_response)
    //     $stripe_response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . config("app.stripe_secret"),
    //         'Content-Type' => 'application/x-www-form-urlencoded',
    //     ])->post("https://api.stripe.com/v1/customers/" . $card_data[6] . "/sources", [
    // 'source' => $card_data[5],
// ]);
// $token = json_encode($card_data[5]);
// dd($token);
        $stripe = new \Stripe\StripeClient(config("app.stripe_secret"));
$stripe->customers->createSource($card_data[6], ['source' => $token]);
        dd($stripe);

        // array_push($card_data,$stripe_response->id);
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

    public function getCardDetails(GetCardDetailsRequest $request, CardDetailsInterface $cardDetails, StripeInterface $stripeGetCards)
    {
        $data = [
            $client_id = $request->client_id,
            $email = $request->email
        ];
        $customers = $stripeGetCards->stripeRead($data);
        if ($customers) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $customers
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

    public function destroyCard(DestroyCardRequest $request, StripeInterface $destroyCardService)
    {
        $data = [
            'card_id' => $request->card_id,
            'client_id' => $request->client_id
        ];
        $response = $destroyCardService->stripeDelete($data);

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
