<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\stripe\CreateChargeService;
use Illuminate\Http\Request;

class MakePaymentController extends Controller
{
    private $charge;
    public function __construct(CreateChargeService $charge)
    {
        $this->charge = $charge;
    }
    public function makePayment(Request $request)
    {
        $data = [
            $amount = $request->amount,
            $customer_id = $request->customer_id,
            $token = $request->token
        ];
        $response = $this->charge->charge($data);
        if ($response) {
            // Company::where('id',$data[])
            return response()->json([
                'message' => 'success',
                'status' => 201,
                'data' => $response
            ], 201);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }
}
