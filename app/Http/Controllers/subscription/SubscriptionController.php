<?php

namespace App\Http\Controllers\subscription;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\stripe\GetAllSubscription;
use App\Services\stripe\CreateSubscriptionService;


class SubscriptionController extends Controller
{
    private $getAllSubscriptions;
    private $createSubscriptions;
    public function __construct(GetAllSubscription $getAllSubscriptions, CreateSubscriptionService $createSubscriptions)
    {
        $this->getAllSubscriptions = $getAllSubscriptions;
        $this->createSubscriptions = $createSubscriptions;
    }
    public function create_subscription(Request $request)
    {
        $isCompanyExists = Company::where('connect_id',$request->customer_id)->exists();
        if($isCompanyExists){
            $company = Company::where('connect_id',$request->customer_id)->first();
            if($company->package=="standard"){
                return response()->json([
                'message' => 'Subscription already available',
                'status' => 500
            ], 500);
            }else{
                $response = $this->createSubscriptions->createSubscription($request->customer_id);
                dd(json_decode($response));
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => json_decode($response)
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 500
            ], 500);
        }
            }
        }
        
    }
    public function getAllSubscriptions()
    {
        $response = $this->getAllSubscriptions->getSubscriptions();
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => json_decode($response)
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }
}
