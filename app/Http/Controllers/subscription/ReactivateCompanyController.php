<?php

namespace App\Http\Controllers\subscription;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerIdRequest;
use App\Services\stripe\CreateYearlySubscriptionService;
use App\Services\stripe\CreateMonthlySubscriptionService;

class ReactivateCompanyController extends Controller
{
    private $createMonthlySubscriptions;
    private $createYearlySubscriptions;
    public function __construct(CreateMonthlySubscriptionService
    $createMonthlySubscriptions, CreateYearlySubscriptionService $createYearlySubscriptions)
    {
        $this->createMonthlySubscriptions = $createMonthlySubscriptions;
        $this->createYearlySubscriptions = $createYearlySubscriptions;
    }
    public function ActivateSuspendedCompanyBySubscription(CustomerIdRequest $request)
    {
        $isCompanyExists = Company::where('connect_id', $request->customer_id)->exists();
        if ($isCompanyExists) {
            $company = Company::where('connect_id', $request->customer_id)->first();
            if ($company->package == $request->package_name && $company->interval == $request->interval) {
                return response()->json([
                    'message' => 'Subscription already available',
                    'status' => 423
                ], 423);
            } else {
                if (
                    $company->package == $request->package_name && $company->interval == 'year' && $request->interval
                    == 'day'
                ) {
                    return response()->json([
                        'message' => 'Cannot use the monthly subscription of this package',
                        'status' => 422
                    ], 422);
                } else {

                    $data = [
                        $customer_id = $request->customer_id,
                        $interval = $request->interval,
                        $package_name = $request->package_name,
                        $price_id = $request->price_id,
                        $active = 1
                    ];
                    $response = "";
                    if ($request->interval == "day") {
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
}
