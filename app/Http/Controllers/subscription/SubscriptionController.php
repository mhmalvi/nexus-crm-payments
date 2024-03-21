<?php

namespace App\Http\Controllers\subscription;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerIdRequest;
use App\Services\stripe\GetAllSubscription;
use App\Interfaces\CreateSubscriptionInterface;
use App\Services\stripe\CreateMonthlySubscriptionService;
use App\Services\stripe\CreateYearlySubscriptionService;


class SubscriptionController extends Controller
{
    private $getAllSubscriptions;
    private $createMonthlySubscriptions;
    private $createYearlySubscriptions;
    public function __construct(GetAllSubscription $getAllSubscriptions, CreateMonthlySubscriptionService
    $createMonthlySubscriptions, CreateYearlySubscriptionService $createYearlySubscriptions)
    {
        $this->getAllSubscriptions = $getAllSubscriptions;
        $this->createMonthlySubscriptions = $createMonthlySubscriptions;
        $this->createYearlySubscriptions = $createYearlySubscriptions;
    }
    public function create_subscription(CustomerIdRequest $request)
    {
        $isCompanyExists = Company::where('connect_id', $request->customer_id)->exists();
        if ($isCompanyExists) {
            $company = Company::where('connect_id', $request->customer_id)->first();
            if ($company->package == $request->package_name && $company->interval == $request->interval) {
                return response()->json([
                    'message' => 'Subscription already available',
                    'status' => 500
                ], 500);
            } else {
                if (
                    $company->package == $request->package_name && $company->interval == 'yearly' && $request->interval
                    == 'monthly'
                ) {
                    return response()->json([
                        'message' => 'Cannot use the monthly subscription of this package',
                        'status' => 500
                    ], 500);
                } else {
                    $data = [
                        $customer_id = $request->customer_id,
                        $interval = $request->interval,
                        $package_name = $request->package_name,
                        $price_id = $request->price_id,
                    ];
                    $response = "";
                    if ($request->interval == "month") {
                        $response = $this->createMonthlySubscriptions->createSubscription($data);
                    } else if ($request->interval == "year") {
                        $response = $this->createYearlySubscriptions->createSubscription($data);
                    }
                    if ($response) {
                        return response()->json([
                            'message' => 'success',
                            'status' => 200,
                            'data' => $response
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
