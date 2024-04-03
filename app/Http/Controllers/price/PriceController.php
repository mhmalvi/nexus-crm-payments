<?php

namespace App\Http\Controllers\price;

use App\Http\Controllers\Controller;
use App\Services\stripe\CreatePriceService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    private $createPrice;
    public function __construct(CreatePriceService $createPrice)
    {
        $this->createPrice = $createPrice;
    }
    public function createPrice(Request $request)
    {
        $data = [
            $currency = $request->currency,
            $unit_amount = $request->unit_amount,
            $interval = $request->interval,
            $product = $request->prod_id,
        ];
        $response = $this->createPrice->createPrice($data);
        if ($response) {
            return response()->json([
                'message' => 'inserted',
                'status' => 201,
                'data' => $response
            ], 201);
        } else {
            return response()->json([
                'message' => 'Not found',
                'status' => 404
            ], 404);
        }
    }
}
