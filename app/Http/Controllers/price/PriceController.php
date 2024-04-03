<?php

namespace App\Http\Controllers\price;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePriceRequest;
use App\Services\stripe\CreatePriceService;

class PriceController extends Controller
{
    private $createPrice;
    public function __construct(CreatePriceService $createPrice)
    {
        $this->createPrice = $createPrice;
    }
    public function createPrice(CreatePriceRequest $request)
    {
        dd($request->all());
        $data = [
            $currency = $request->currency,
            $unit_amount = $request->unit_amount,
            $interval = $request->interval,
            $product = $request->prod_id,
            $client_id = $request->client_id
        ];
        $response = $this->createPrice->createPrice($data);
        if ($response == 422) {
            return response()->json([
                'message' => 'Price already exists',
                'status' => $response
            ], $response);
        } else {
            return response()->json([
                'message' => 'inserted',
                'status' => 201,
                'data' => $response
            ], 201);
        }
    }
}
