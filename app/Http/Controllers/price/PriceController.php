<?php

namespace App\Http\Controllers\price;

use App\Models\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePriceRequest;
use App\Services\stripe\CreatePriceService;
use App\Services\stripe\GetPricesService;

class PriceController extends Controller
{
    private $createPrice;
    private $getPrices;
    public function __construct(CreatePriceService $createPrice, GetPricesService $getPrices)
    {
        $this->createPrice = $createPrice;
        $this->getPrices = $getPrices;
    }
    public function createPrice(CreatePriceRequest $request)
    {
        $data = [
            $currency = $request->currency,
            $unit_amount = $request->unit_amount,
            $interval = $request->interval,
            $product = $request->prod_id,
            $client_id = $request->client_id
        ];
        $prod = Price::where('prod_id', $data[3])->exists();
        if ($prod) {
            $price =
                Price::orWhere('unit_amount', $data[1])->orWhere('interval', $data[2])->exists();
            if ($price) {
                return response()->json([
                    'message' => 'Price already exists',
                    'status' => 422
                ], 422);
            } else {
                $response = $this->createPrice->createPrice($data);
                return response()->json([
                    'message' => 'inserted',
                    'status' => 201,
                    'data' => $response
                ], 201);
            }
        } else {
            $response = $this->createPrice->createPrice($data);
            return response()->json([
                'message' => 'inserted',
                'status' => 201,
                'data' => $response
            ], 201);
        }
    }

    public function getPrices(Request $request)
    {
        $prices = $this->getPrices->getPrices($request->prod_id);
        if ($prices) {
            return response()->json([
                $prices
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }
}
