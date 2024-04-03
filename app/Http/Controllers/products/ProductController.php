<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct(Request $request){
        $stripe = new
        \Stripe\StripeClient(config("app.stripe_secret"));
        $prods = $stripe->products->all(['limit' => 3]);
        dd($prods);
    }
}
