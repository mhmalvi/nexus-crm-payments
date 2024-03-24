<?php

namespace App\Http\Controllers\subscription;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerIdRequest;
use App\Services\stripe\GetAllSubscription;
use App\Interfaces\CreateSubscriptionInterface;
use App\Services\stripe\CreateYearlySubscriptionService;
use App\Services\stripe\CreateMonthlySubscriptionService;


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

    public function trialCheck(Request $request)
    {
        $company = Company::find($request->company_id);
        $company = json_decode($company);
        // foreach($company as $data){
        // $result = Carbon::createFromFormat('d/m/Y H:i:s',$company->end_date);
        if ($company->package == "trial") {
            $date = $company->end_date;
            $date = Carbon::parse($date)->subDays(3);
            dd($company->business_email);
            if (Carbon::now() == $date) {
                // Mail::to()
            } else {
                dd('false');
            }
        }

        // }

    }
}
