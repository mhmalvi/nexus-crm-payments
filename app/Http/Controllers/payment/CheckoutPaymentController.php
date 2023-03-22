<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\PaymentHistory;
use App\Models\PaymentSettings;
use App\Models\Invoices;
use App\Models\StripeConnect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Omnipay\Omnipay;
use Throwable;
use Session;
use Stripe;
use DB;


use function PHPUnit\Framework\throwException;

//require('vendor/autoload.php');

class CheckoutPaymentController extends Controller
{
    /**
     * Get Payment Histories
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentHistories(Request $request)
    {

        try {
            $paymentList = PaymentHistory::select(
                'payment_method',
                'payment_amount',
                'payment_status',
                'last_name',
                'company_name',
                'invoice_number',
                'transaction_id',
                'lead_id',
                'payment_status',
                'company_id',
                'user_id',
                'created_at'
            );
            if (isset($request->user_id))
                $paymentList = $paymentList->where('user_id', $request->user_id);

            if (isset($request->company_id))
                $paymentList = $paymentList->where('company_id', $request->company_id);

            $paymentList = $paymentList->get();
            // dd($leadCheckList);
            if ($paymentList == "") {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found',
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'All Payment',
                'data'    => $paymentList->toArray()
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get Payment Histories By Lead
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentHistoriesByLead(Request $request)
    {
        if (!isset($request->lead_id))
            return response()->json([
                'status' => false,
                'message' => 'Lead Id not found',
            ], 404);

        try {
            $paymentList = Invoices::where('lead_id', $request->lead_id)->get();

            // dd($leadCheckList);
            if ($paymentList == "") {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found',
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'All Payment',
                'data'    => $paymentList->toArray()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get Payment Histories
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceHistories(Request $request)
    {

        try {
            $paymentList = Invoices::select('*');
            if (isset($request->id))
                $paymentList = $paymentList->where('id', $request->id);

            if (isset($request->user_id))
                $paymentList = $paymentList->where('user_id', $request->user_id);

            if (isset($request->company_id))
                $paymentList = $paymentList->where('company_id', $request->company_id);

            $paymentList = $paymentList->get();
            // dd($leadCheckList);
            if ($paymentList == "") {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found',
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'All Payment',
                'data'    => $paymentList->toArray()
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        /*  $amount = 8000;
        $apiKey = "60CF3C/0J3M6IjagJA/zU9xamgohbhFLJs6sP20t+pdkke8zOUmzsCVkHym5u7Wwc4Ra7R";
        $apiPassword = "g9GMnRNQ";
        $apiEndpoint = 'Sandbox';

        // Create the eWAY Client
        $client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

        // Transaction details - these would usually come from the application
        $transaction = [
            'Customer' => [
                'FirstName' => 'John',
                'LastName' => 'Smith',
                'Street1' => 'Level 5',
                'Street2' => '369 Queen Street',
                'City' => 'Sydney',
                'State' => 'NSW',
                'PostalCode' => '2000',
                'Country' => 'au',
                'Email' => 'demo@example.org',
                'Phone' => 61485828833

            ],
            // These should be set to your actual website (on HTTPS of course)
            'RedirectUrl' => route('success'),
            'CancelUrl' => route('fail'),
            'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE,
            'Payment' => [
                'TotalAmount' => $amount,
            ]
        ];

        // Submit data to eWAY to get a Shared Page URL
        $response = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::RESPONSIVE_SHARED, $transaction);

        $ewayfile = fopen('eway.txt', 'w');
        fwrite($ewayfile, $response);
        fclose($ewayfile);


        // Check for any errors
        $sharedURL = '';
        if (!$response->getErrors()) {

            $sharedURL = $response->SharedPaymentUrl;
            return redirect($sharedURL);
        } */
    }

    /**
     * Show the success response of payment
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {

        /*   // eWAY Credentials
        $apiKey = '60CF3C/0J3M6IjagJA/zU9xamgohbhFLJs6sP20t+pdkke8zOUmzsCVkHym5u7Wwc4Ra7R';
        $apiPassword = 'g9GMnRNQ';
        $apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;

        // Create the eWAY Client
        $client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

        // Query the transaction result.
        $response = $client->queryTransaction($_GET['successCode']);

        $transactionResponse = $response->Transactions[0];

        // Display the transaction result
        if ($transactionResponse->TransactionStatus) {
            echo 'Payment successful! ID: ';


            $ewayfile = fopen('eway.txt', 'a');
            fwrite($ewayfile, "Transaction id: " . $transactionResponse->TransactionID);
            // fwrite($ewayfile, "Transaction id: " . $transactionResponse->TransactionID);
            fclose($ewayfile);
        } else {

            echo "Payment failed: ";
        } */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment_details($lead_id)
    {
        $payment_details = PaymentHistory::where('lead_id', $lead_id)->where('payment_status', 'succeeded')->get();
        // $invoice = Invoices::where('lead_id', $lead_id)->
        if (!$payment_details->isEmpty()) {
            // dd($payment_details);
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $payment_details
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'status' => 404,
            ], 404);
        }
    }

    public function get_companies()
    {
        $connect = StripeConnect::all();
        if (!$connect->isEmpty()) {
            return response()->json([
                'message' => 'success',
                'data' => $connect
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
    }

    public function stripePost(Request $request)
    {
        // Stripe\StripeClient(env('STRIPE_SECRET'));
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // Stripe\Charge::create([
        //     "amount" => 100 * 100,
        //     "currency" => "INR",
        //     "source" => $request->stripeToken,
        //     "description" => "This is test payment",
        // ]);

        // $payment_intent = \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'payment_method' => $method->id,
        //     'amount' => 1000,
        //     'currency' => 'aud',
        //     'automatic_payment_methods' => ['enabled' => true],
        //     'application_fee_amount' => 123,
        //     'transfer_data' => [
        //         'destination' => 'acct_1Mllh7QUyNH9Tbzo',
        //     ],
        // ]);

        // $method = \Stripe\PaymentMethod::create([
        //     'type' => 'card',
        //     'card' => [
        //         // 'number' => '378282246310005',
        //         // 'exp_month' => 12,
        //         // 'exp_year' => 2026,
        //         // 'cvc' => '314',

        //         'number' => $request->card_number,
        //         'exp_month' => $request->exp_month,
        //         'exp_year' => $request->exp_year,
        //         'cvc' => $request->cvc,
        //     ],
        // ]);

        // $data = \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'payment_method' => $method->id,
        //     'amount' => 2 * 100,
        //     'currency' => 'AUD',
        // ]);

        // $data = json_encode($data);



        // $transfer = \Stripe\Transfer::create([
        //     'amount' => 2 * 100,
        //     'currency' => 'USD',
        //     'destination' => 'acct_1MlcsCQhHfdpdP56',
        //     // 'transfer_group' => '{ORDER' . $_SESSION['order_id'] . '}',
        // ]);
        // dd($request->stripeToken);

        ///////////////////////////////////////////////////////////////////
        $customer = Stripe\Charge::create(
            [
                // 'type' => 'card',
                // 'mode' => 'payment',
                "amount" => $request->amount * 100,
                "currency" => "AUD",
                // 'stripe_account' => 'acct_1MlcsCQhHfdpdP56',
                //   'line_items' => [['price' => '{{PRICE_ID}}', 'quantity' => 1]],
                // 'payment_intent_data' => ['application_fee_amount' => 123],
                "source" => $request->stripeToken,
                "description" => "This is test payment for us",
                // 'stripe_account' => 'acct_1MlcsCQhHfdpdP56'
                //   'success_url' => 'http://example.com/success',
                //   'cancel_url' => 'http://localhost:8000/',
            ],
            ['stripe_account' => 'acct_1MlcsCQhHfdpdP56']
        );

        /////////////////////////////////////////////////////////



        return response()->json([
            'message' => 'success',
            'data' => $customer
        ]);
        // $data = json_encode($customer);
        // dd($data);
        // return response()->json([
        //     'data'=>$data
        // ]);
        // Session::flash('success', 'Payment Successful !');

        // return back();
    }

    public function ewayPayemntResponse(Request $request)
    {
        // dd("dfgdg");
        $userId = isset($request->user_id) ? $request->user_id : 0; //it will come from api
        $leadId = isset($request->lead_id) ? $request->lead_id : 0; //it will come from api
        $companyId = isset($request->client_id) ? $request->client_id : 0; //it will come from api
        $paymentMethod = $request->payment_method; //it will come from api
        // dd($paymentMethod);
        // $accessCode = $request->accessCode;
        try {
            // eWAY Credentials
            // $eWayCredentials = PaymentSettings::where('company_id', $companyId)->where('payment_method', $paymentMethod)->first();
            // if ($eWayCredentials == "") {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Company not found',
            //     ], 401);
            // }
            // $api_key = $eWayCredentials->api_key;
            // $api_password = $eWayCredentials->api_password;

            // $apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;

            // $client = \Eway\Rapid::createClient($api_key, $api_password, $apiEndpoint);
            // // Query the transaction result.
            // $response = $client->queryTransaction($accessCode);
            //convert data into array

            //////////////////////////////////////////////////////////////////////////////////////////
            // $key = env('STRIPE_SECRET');
            // dd($key);
            // $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            // dd($companyId);
            $connect_id = Http::get('https://crmcompany.quadque.digital/api/company/' . $companyId . '/details');
            $connect = json_decode($connect_id->body())->data[0]->connect;
            // dd($response);
            Stripe\Stripe::setApiKey('sk_test_51JCKihHrHTHAD5zZ7ELiP2pz6vTEL8vE120Ed8X0vPSvfzOBoARKkVAFm0VFg958FkXGSRJatofINWoHCXdzEOzW00NLLlB5ps');

            $stripe = new \Stripe\StripeClient(
                'sk_test_51JCKihHrHTHAD5zZ7ELiP2pz6vTEL8vE120Ed8X0vPSvfzOBoARKkVAFm0VFg958FkXGSRJatofINWoHCXdzEOzW00NLLlB5ps'
            );
            // dd($stripe);
            // $response = \Stripe\Token::create(array(
            //     "card" => array(
            //         "number"    => 4242424242424242,
            //         "exp_month" => 3,
            //         "exp_year"  => 2024,
            //         "cvc"       => 321,
            //         "name"      => "David"
            //     )
            // ));
            // $response = $response->id;
            $token = $stripe->tokens->create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 3,
                    'exp_year' => 2024,
                    'cvc' => '314',
                ],
            ]);
            // dd($token);
            // $stripe->customers->create([
            //     'name'=>$request->full_name,
            //     'email'=>$request->user_email,
            //     'description' => 'customer',
            // ], ['stripe_account' => 'acct_1MlcsCQhHfdpdP56']);
            $payment_response = Stripe\Charge::create(
                [
                    // 'type' => 'card',
                    // 'mode' => 'payment',
                    "amount" => $request->amount * 100,
                    "currency" => "AUD",
                    // "customer" => "acct_1MlcsCQhHfdpdP56",
                    // 'stripe_account' => 'acct_1MlcsCQhHfdpdP56',
                    //   'line_items' => [['price' => '{{PRICE_ID}}', 'quantity' => 1]],
                    // 'payment_intent_data' => ['application_fee_amount' => 123],
                    "source" => $token,
                    // "source" => $response,
                    "description" => "This is test payment",
                    // 'stripe_account' => 'acct_1MlcsCQhHfdpdP56'
                    //   'success_url' => 'http://example.com/success',
                    //   'cancel_url' => 'http://localhost:8000/',
                ],
                ['stripe_account' => $connect]
            );
            // dd("hrllo");
            // dd($data);
            // $response = json_encode($data);
            // dd($response);
            // $client_response = $response->Transactions[0];
            // $paymentStatus = "FAILED";
            // if ($client_response->TransactionStatus == 1) {
            //     $paymentStatus = "COMPLETED";
            // }
            // store all payement information on payment history table
            // dd($client_response);
            // dd($payment_response->status);
            $history = PaymentHistory::updateOrcreate([
                'payment_method' => $payment_response->payment_method_details->card->brand,
                'payment_amount' => $request->amount,
                'campaign_id' => $request->campaign_id,
                'user_id' => $userId, //it will come from api
                'company_id' => $companyId,
                'payment_status' => $payment_response->status,
                'payment_log' => json_encode($payment_response),
                'lead_id' => "$leadId", ////it will come from api
                // 'Authorisation_code' => $client_response->AuthorisationCode,
                // 'response_code' => $client_response->ResponseCode,
                // 'response_msg' => $client_response->ResponseMessage,
                // 'invoice_number' => $response->InvoiceNumber,
                // 'invoice_ref' => $client_response->InvoiceReference,
                'transaction_id' => $payment_response->balance_transaction,
                // 'first_name' => $client_response->Customer->FirstName,
                // 'last_name' => $client_response->Customer->LastName,
                // 'company_name' => $client_response->Customer->CompanyName,
                // 'job_description' => $client_response->Customer->JobDescription,
                // 'street1' => $client_response->Customer->Street1,
                // 'street2' => $client_response->Customer->Street2,
                // 'city' => $client_response->Customer->City,
                // 'state' => $client_response->Customer->State,
                // 'postal_code' => $client_response->Customer->PostalCode,
                // 'country' => $client_response->Customer->Country,
                // 'email' => $client_response->Customer->Email,
                // 'phone' => $client_response->Customer->Phone,
                // 'mobile' => $client_response->Customer->Mobile,
                // 'comments' => $client_response->Customer->Comments,
                // 'fax' => $client_response->Customer->Fax,
                // 'url' => $client_response->Customer->Url,
            ]);

            // dd($history);
            // return response()->json([
            //     'message'=>'success',
            //     ''
            // ]);

            $companyServiceAPI = env('COMPANY_SERVICE_API', '');

            $response = Http::get('https://crmcompany.quadque.digital/api/company/' . $companyId . '/details');

            // dd($response->body());
            $companyData = isset(json_decode($response->body())->data[0]) ? json_decode($response->body())->data[0] : '';
            $companyLogo = '';
            // dd($companyData->logo_id);
            if (isset($companyData->logo_id) && $companyData->logo_id != "") {
                $fileServiceAPI = env('FILE_SERVICE_API');

                $response = Http::get('https://crmcompany.quadque.digital/api/documents/' . $companyData->logo_id);
                $companyLogo = isset(json_decode($response->body())->data->document_name) ? json_decode($response->body())->data->document_name : '';
            }
            $companyData->logo = $companyLogo;
            $leadDetails = "";
            $userDetails = "";
            // if (isset($client_response->TransactionStatus) && $client_response->TransactionStatus != "") {
            //Make Invoice //

            // $record = Invoices::latest()->first();

            $nextInvoiceNumber = date('d/m/Y') . '-' . $userId . '000001';
            // if ($record != "") {

            //     $expNum = explode('-', $record->invoice_id);

            //     $nextInvoiceNumber = $expNum[0] . '-' . ($expNum[1] + 1);
            // }

            //                if($leadId>0){
            //                    $leadServiceAPI = env('LEAD_SERVICE_API', '');
            //                    //dd($userServiceAPI);
            //                    $response = Http::post($leadServiceAPI.'/lead/details', [
            //                        'lead_id' => $leadId
            //                    ]);
            //                    $leadDetails = json_decode($response->body());
            //                    //dd(json_decode($response->body()));
            //                }



            //                if($userId>0){
            //
            //                    $userServiceAPI = env('USER_SERVICE_API', '');
            //                    //dd($userServiceAPI);
            //                    $response = Http::post($userServiceAPI.'/user/list', [
            //                        'users' => json_encode(array($userId))
            //                    ]);
            //
            //                    $userDetails = json_decode($response->body());
            //                    //dd($userDetails);
            //
            //                }
            //dd($userDetails->data[0]->email);
            //dd($nextInvoiceNumber);
            $invoiceData = Invoices::updateOrcreate([
                'invoice_id' => $nextInvoiceNumber,
                'transaction_id' => $payment_response->balance_transaction,
                'lead_id' => isset($request->lead_id) ? $request->lead_id : 0,
                'company_id' => isset($companyId) ? $companyId : 0,
                'user_id' => isset($request->user_id) ? $request->user_id : 0,
                'company_name' => isset($companyData->name) ? $companyData->name : '',
                'company_logo' => isset($companyData->logo) ? $companyData->logo : '',
                'course_code' => isset($request->course_code) ? $request->course_code : '',
                'course_title' => isset($request->course_title) ? $request->course_title : '',
                'package_id' => isset($request->package_id) ? $request->package_id : 0,
                'package_name' => isset($request->package_name) ? $request->package_name : '',
                'payment_amount' => ($payment_response->amount > 0) ? ($payment_response->amount) : 0,
                'payment_method' => isset($payment_response->payment_method_details->brand) ? $payment_response->payment_method_details->brand : '',
                'payer_name' =>  isset($request->full_name) ? $request->full_name : '',
                'payer_email' => isset($request->user_email) ? $request->user_email : '',
                'company_email' => isset($companyData->business_email) ? $companyData->business_email : '',
                'company_contact' => isset($companyData->contact) ? $companyData->contact : '',
                'company_website' => isset($companyData->website) ? $companyData->website : '',
                'role_id' => isset($request->role_id) ? $request->role_id : '',
            ]);

            $history->invoice_number = $nextInvoiceNumber;
            $history->save();

            ///EOF Invoice ////
            //send response
            $emailServiceAPI = env('EMAIL_SERVICE_API', '');
            $invoiceData->invoice_date = Carbon::parse($invoiceData->created_at)->toDateTimeString();
            // dd($invoiceData);
            $response = Http::post('https://crm-mailer.onrender.com/api/send-payment-mail', [
                'data' => json_encode($invoiceData)
            ]);
            $emailStatus = false;
            if ($response->status() == '200') {
                $emailStatus = true;
            }
            // dd($companyData);

            // Course Details from lead details

            return response()->json([
                'message' => true,
                'status' => 200,
                'key' => 'success',
                'transaction_id' => $payment_response->balance_transaction,
                'message' => 'Payment Completed Successfully ',
                'Email Status' => $emailStatus
            ], 200);
            // } else {

            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Invalid response'
            //     ], 500);
            // }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function weekly_payment(Request $request)
    {
        $date = Carbon::now()->subDays(7);

        $payments = PaymentHistory::select(DB::raw('sum(payment_amount) as sum'), DB::raw("DATE_FORMAT(created_at,'%D') as dates"))->groupBy('dates')->whereYear('created_at', date('Y'))->where('created_at', '>=', $date)->where('company_id', $request->company_id)->get();

        if ($payments) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $payments
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500,
            ], 500);
        }
    }

    public function campaign_wise_payment(Request $request)
    {
        $payments = PaymentHistory::select(
            DB::raw('sum(payment_amount) as sums'),
            DB::raw('campaign_id as campaigns'),
        )
            ->groupBy('campaigns')->where('company_id', $request->company_id)->get();
        if ($payments) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $payments
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500,
            ], 500);
        }
    }

    public function monthlyPayment(Request $request)
    {
        $payments = PaymentHistory::select(
            DB::raw('sum(payment_amount) as revenue'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->groupBy('months',)
            ->whereYear('created_at', date('Y'))
            ->where('company_id', $request->company_id)
            ->get();

        // $payments = PaymentHistory::select(
        //     DB::raw('sum(payment_amount) as sums'),
        //     DB::raw("DATE_FORMAT(created_at,'%M') as months")
        // )
        //     ->whereYear('created_at', date('Y'))
        //     ->where('company_id', $request->company_id)
        //     ->groupBy('months')
        //     ->get();
        if ($payments) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $payments
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500,
            ], 500);
        }
    }

    // store paypal info in payment history table and send response
    public function paypalPayemntResponse(Request $request)
    {

        $userId = $request->user_id; //it will come from api
        $leadId = $request->lead_id; //it will come from api
        $paymentMethod = $request->payment_method; //it will come from api

        $client_response = [
            'create_time' => '2022-09-29T10:59:10Z',
            'update_time' => '2022-09-29T10:59:22Z',
            'orderID' => '5PC23671CH936720Y',
            'intent' => 'CAPTURE',
            'status' => 'COMPLETED',
            'address' => '',
            'country_code' =>   "US",
            'email_address' => "sb-vouos20396551@personal.example.com",
            'links' => [
                'href' => "https://api.sandbox.paypal.com/v2/checkout/orders/5PC23671CH936720Y"

            ],
            'name' => [
                'given_name' => "John",
                'surname' =>  "Doe"
            ],
            'payer_id'  => "GGHH982LV896Q",
            'purchase_units' => [
                'amount' => [
                    'currency_code' => "AUD",
                    'value' => "1080.00"
                ]
            ],
            'reference_id' => "default",
            'shipping' => [
                'address' => [
                    'address_line_1' =>   "1 Main St",
                    'admin_area_1' =>  "CA",
                    'admin_area_2' =>  "San Jose",
                    'country_code'  =>   "US",
                    'postal_code' =>    "95131"
                ]
            ]
        ];


        $client_response =  json_encode($client_response);
        $client_response = json_decode($client_response);
        try {

            PaymentHistory::create([

                'payment_method' => $paymentMethod,
                'payment_amount' => $client_response->purchase_units->amount->value,
                'user_id' => $userId, //it will come from api
                'payment_status' => $client_response->status,
                'payment_log' => json_encode($client_response),
                'lead_id' => $leadId, ////it will come from api
                'Authorisation_code' => $client_response->AuthorisationCode ?? null,
                'response_code' => $client_response->ResponseCode ?? null,
                'response_msg' => $client_response->ResponseMessage ?? null,
                'invoice_number' => $client_response->InvoiceNumber ?? null,
                'invoice_ref' => $client_response->InvoiceReference ?? null,
                'transaction_id' => $client_response->orderID,
                'payer_id' => $client_response->payer_id,
                'first_name' => $client_response->name->given_name,
                'last_name' => $client_response->name->surname,
                'company_name' => $client_response->companyName ?? null,
                'job_description' => $client_response->JobDescription ?? null,
                'street1' => $client_response->Street1 ?? null,
                'street2' => $client_response->Street2 ?? null,
                'city' => $client_response->City ?? null,
                'state' => $client_response->State ?? null,
                'postal_code' => $client_response->shipping->address->postal_code,
                'country' => $client_response->Country ?? null,
                'email' => $client_response->email_address,
                'phone' => $client_response->Phone ?? null,
                'mobile' => $client_response->Mobile ?? null,
                'comments' => $client_response->Comments ?? null,
                'fax' => $client_response->Fax ?? null,
                'url' => $client_response->Url ?? null,
            ]);

            if ($client_response->status) {
                //send response
                return response()->json([
                    'status' => true,
                    'key' => 'success',
                    'transaction_id' => $client_response->orderID,
                    'message' => 'Payment Completed Successfully'
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid response'
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
