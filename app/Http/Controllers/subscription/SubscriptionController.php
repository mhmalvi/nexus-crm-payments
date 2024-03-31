<?php

namespace App\Http\Controllers\subscription;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CustomerIdRequest;
use App\Services\stripe\GetAllSubscription;
use App\Interfaces\CreateSubscriptionInterface;
use App\Mail\SubscriptionMail;
use App\Mail\TrialPeriodMail;
use App\Services\stripe\CreateYearlySubscriptionService;
use App\Services\stripe\CreateMonthlySubscriptionService;
use App\Services\stripe\RetrieveASubscriptionService;
use App\Services\stripe\UpgradeSubscriptionService;

class SubscriptionController extends Controller
{
    private $getAllSubscriptions;
    private $createMonthlySubscriptions;
    private $createYearlySubscriptions;
    private $upgradeSubscriptions;
    private $retrieveSubscription;
    public function __construct(GetAllSubscription $getAllSubscriptions, CreateMonthlySubscriptionService
    $createMonthlySubscriptions, CreateYearlySubscriptionService $createYearlySubscriptions, UpgradeSubscriptionService
    $upgradeSubscriptions, RetrieveASubscriptionService $retrieveSubscription)
    {
        $this->getAllSubscriptions = $getAllSubscriptions;
        $this->createMonthlySubscriptions = $createMonthlySubscriptions;
        $this->createYearlySubscriptions = $createYearlySubscriptions;
        $this->upgradeSubscriptions = $upgradeSubscriptions;
        $this->retrieveSubscription = $retrieveSubscription;
    }
    public function create_subscription(CustomerIdRequest $request)
    {
        $isCompanyExists = Company::where('connect_id', $request->customer_id)->exists();
        // dd($request->all());
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
                } else{
// dd($request->all());
                    $data = [
                        $customer_id = $request->customer_id,
                        $interval = $request->interval,
                        $package_name = $request->package_name,
                        $price_id = $request->price_id,
                        $active = 1,
                    ];
                    // dd($data);
                    $response = "";
                    if($company->interval == 'day' && $request->interval == 'year'){
                        array_push($data,$request->sub_id);
                        $s_id = $this->retrieveSubscription->retrieveSubscription($request->sub_id);
                        // dd($s_id->items->data[0]['id']);
                        array_push($data,$s_id->items->data[0]['id']);
                        $response = $this->upgradeSubscriptions->upgradeSubscription($data);
                    }else if ($request->interval == "day" && $company->package_name == 'trial') {
                        dd('day');
                        $response = $this->createMonthlySubscriptions->createSubscription($data);
                    } else if ($request->interval == "year" && $company->interval != 'day') {
                        dd('year');
                        $response = $this->createYearlySubscriptions->createSubscription($data);
                    }
                    // dd($response);
                    if ($response) {
                        Mail::to($company->business_email)->send(new
                        SubscriptionMail($company->business_email,$company->name));
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
        // $company = json_decode($company);
        // dd($company->business_email);
        // foreach($company as $data){
        // $result = Carbon::createFromFormat('d/m/Y H:i:s',$company->end_date);
        // if ($company->package == "trial") {
            $date = $company->end_date;
            $date_three = Carbon::parse($date)->subDays(3);
            $date_seven = Carbon::parse($date)->subDays(7);
            // dd($company->business_email);
            // $date = date('Y-m-d H:i',$date);
            dd($date);
            // if (Carbon::now() == $date_three) {
            //     Mail::to($company->business_email)->queue(new TrialPeriodMail());
            // } else if(Carbon::now() == $date_seven){
            //     Mail::to($company->business_email)->queue(new TrialPeriodMail());
            // }
        // }

        // }

    }
}
