<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $products;
    public function __construct($products)
    {
        $this->products = $products;
    }
    public function getProduct(Request $request)
    {
        $products = $this->products->getProducts();
        if ($products) {
            return response()->json([
                'messsage' => 'success',
                'status' => 200,
                'data' => $products
            ], 200);
        } else {
            return response()->json([
                'messsage' => 'No product found',
                'status' => 404
            ], 404);
        }
    }
}
