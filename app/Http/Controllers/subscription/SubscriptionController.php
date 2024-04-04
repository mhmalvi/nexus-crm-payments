<?php

namespace App\Http\Controllers\subscription;

use DateTimeZone;
use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Mail\TrialPeriodMail;
use App\Mail\SubscriptionMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionUpgradeMail;
use App\Http\Requests\CustomerIdRequest;
use App\Services\stripe\GetAllSubscription;
use App\Interfaces\CreateSubscriptionInterface;
use App\Services\stripe\UpgradeSubscriptionService;
use App\Services\stripe\RetrieveASubscriptionService;
use App\Services\stripe\CreateYearlySubscriptionService;
use App\Services\stripe\CreateMonthlySubscriptionService;

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
                } else {
                    // dd($request->all());
                    $data = [
                        $customer_id = $request->customer_id,
                        $interval = $request->interval,
                        $package_name = $request->package_name,
                        $price_id = $request->price_id,
                        $active = 1,
                    ];

                    $response = "";
                    if ($company->interval == 'day' && $request->interval == 'year') {
                        // dd($request->sub_id);
                        array_push($data, $request->sub_id);
                        $s_id = $this->retrieveSubscription->retrieveSubscription($request->sub_id);
                        // dd($s_id->items->data[0]['id']);
                        array_push($data, $s_id->items->data[0]['id']);
                        // dd($data);
                        $response = $this->upgradeSubscriptions->upgradeSubscription($data);
                        if ($response) {
                            Mail::to($company->business_email)->send(new
                                SubscriptionUpgradeMail($company->business_email, $company->name, $request->interval, $request->package_name));
                            return response()->json([
                                'message' => 'success',
                                'status' => 200,
                                'data' => $response
                            ], 200);
                        }
                    }
                    // dd(json_decode($company)->package);
                    if ($request->interval == "day" && $company->package == 'trial') {
                        // dd('day');
                        // dd($data);
                        $response = $this->createMonthlySubscriptions->createSubscription($data);
                        // dd($response);
                        if ($response) {
                            Mail::to($company->business_email)->send(new
                                SubscriptionMail(
                                    $company->business_email,
                                    $company->name,
                                    $request->interval,
                                    $request->package_name
                                ));
                            return response()->json([
                                'message' => 'success',
                                'status' => 200,
                                'data' => $response
                            ], 200);
                        }
                    }
                    if ($request->interval == "year" && $company->interval != 'day') {
                        $response = $this->createYearlySubscriptions->createSubscription($data);
                        // dd($response);
                        if ($response) {
                            Mail::to($company->business_email)->send(new
                                SubscriptionMail(
                                    $company->business_email,
                                    $company->name,
                                    $request->interval,
                                    $request->package_name
                                ));
                            return response()->json([
                                'message' => 'success',
                                'status' => 200,
                                'data' => $response
                            ], 200);
                        }
                    }
                    // dd($response);
                    // if ($response) {
                    //     Mail::to($company->business_email)->send(new
                    //         SubscriptionMail($company->business_email, $company->name));
                    //     return response()->json([
                    //         'message' => 'success',
                    //         'status' => 200,
                    //         'data' => $response
                    //     ], 200);
                    // } else {
                    //     return response()->json([
                    //         'message' => 'Failed',
                    //         'status' => 500
                    //     ], 500);
                    // }
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
        $ip = $request->ip();
        // $ip="119.18.3.81";
        // dd($ip);
        $url = 'http://ip-api.com/json/' . $ip;
        $tz = file_get_contents($url);
        $tz = json_decode($tz, true)['timezone'];
        // dd($tz);
        $zone = json_encode(Carbon::now($tz));
        // dd(Carbon::now($tz)->date);
        $time = substr($zone, 12, 13);
        // dd($time);
        $time_str = substr($time, 0, 8);
        // dd($time_sub);
        $date_str = substr($zone, 1, 10);
        // dd($sub_str);
        $date_time_str = $date_str . ' ' . $time_str;
        // dd($date_time_str);
        // dd(Carbon::parse($tz)->format("Y-m-d H:i:s"));
        $company = Company::where('active', 1)->get();
        foreach ($company as $company) {
            if ($company->package == "trial") {
                $date = $company->end_date;
                $date_one = Carbon::parse($date)->subDays(1);
                $date_three = Carbon::parse($date)->subDays(3);
                $date_seven = Carbon::parse($date)->subDays(7);

                print_r('end date');

                $end_date = Carbon::parse($date);
                // $date = json_encode($date->timezone($tz));
                print_r($end_date = json_encode($end_date->timezone($tz)));
                $date_three = json_encode($date_three->timezone($tz));
                $date_seven = json_encode($date_seven->timezone($tz));
                print_r('curr date');
                $current_time = Carbon::now()->addHours(6);
                $current_time = $current_time->timezone($tz);
                print_r($current_time = json_encode($current_time));
                print_r('date one');
                $date_one = json_encode($date_one->timezone($tz));
                print_r($date_one);
                if ($current_time == $date_three) {
                    Mail::to($company->business_email)->send(new TrialPeriodMail($company->end_date, 3));
                } else if ($current_time == $date_seven) {
                    Mail::to($company->business_email)->send(new TrialPeriodMail($company->end_date, 7));
                } else if (
                    $current_time >= $date_one
                ) {
                    print_r('true');
                    Mail::to($company->business_email)->send(new
                        TrialPeriodMail($company->end_date, 1));
                } else if ($current_time == $date) {
                    Mail::to($company->business_email)->send(new TrialPeriodMail($company->end_date, 0));
                }
                if (
                    isset($company->end_date) && $current_time >
                    $company->end_date
                ) {
                    $company->active = 2;
                    $company->subscription_id = "";
                    $company->save();
                }
            }
        }
    }
}
