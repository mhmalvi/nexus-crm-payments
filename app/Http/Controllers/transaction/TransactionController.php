<?php

namespace App\Http\Controllers\transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerIdRequest;
use App\Services\stripe\GetCustomerTransactionsService;

class TransactionController extends Controller
{
    public function __construct(GetCustomerTransactionsService $getCustomerTransactions){
        $this->getCustomerTransactions = $getCustomerTransactions;
    }
    public function retrieve_transactions(CustomerIdRequest $request){
        $response = $this->getCustomerTransactions->getCustomerTransactions($request->customer_id);
        if($response){
            return response()->json([
                'message'=>'success',
                'status'=>200,
                'data'=>$response
            ],200);
        }else{
            return response()->json([
                'message'=>'no transactions found',
                'status'=>404
            ],404);
        }
    }
}
