<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Omnipay\Omnipay;


class CheckoutPaymentController extends Controller
{
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
        $response = $client->queryTransaction($_GET['AccessCode']);

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
     * @return \Illuminate\Http\Response
     */
    public function ewayPayemntResponse(Request $request)
    {

        //get the response 
        //$response = Http::get('http://example.com');
        //$response_body = $response->body();

        $user_id = 1; //it will come from api
        $lead_id = 1; //it will come from api

        //it will come from api
        $accessCode = '44DD7TdV8qmLXZlxfM6uCSQPQRclc792WsD_1y8cdIJngfLpnkFFKa2UXQ2RIFpMVnUxV8ZKq7F8ttzc6fZWlfM8rJo68_2bXggf9ZOEtysixIjL38iamDkQsUM9cT2arPmW_agZ_zniHL_XmPAInuWbcDw==';

        // eWAY Credentials
        $api_key = '60CF3C/0J3M6IjagJA/zU9xamgohbhFLJs6sP20t+pdkke8zOUmzsCVkHym5u7Wwc4Ra7R';
        $api_password = 'g9GMnRNQ';
        $apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;

        $ch = curl_init();

        // Note: using the Sandbox API endpoint
        curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.ewaypayments.com/Transaction/' . $accessCode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($output);

        $client_response = $result->Transactions[0];
        //  dd($client_response->Customer->TokenCustomerID);

        PaymentHistory::create([

            'payment_method' => 'eWay',
            'payment_amount' => $client_response->TotalAmount,
            'user_id' => $user_id, //it will come from api
            'payment_status' => $client_response->TransactionStatus,
            'payment_log' => json_encode($client_response),
            'lead_id' => $lead_id, ////it will come from api
            'Authorisation_code' => $client_response->AuthorisationCode,
            'response_code' => $client_response->ResponseCode,
            'response_msg' => $client_response->ResponseMessage,
            'invoice_number' => $client_response->InvoiceNumber,
            'invoice_ref' => $client_response->InvoiceReference,
            'transaction_id' => $client_response->TransactionID,
            'first_name' => $client_response->Customer->FirstName,
            'last_name' => $client_response->Customer->LastName,
            'company_name' => $client_response->Customer->CompanyName,
            'job_description' => $client_response->Customer->JobDescription,
            'street1' => $client_response->Customer->Street1,
            'street2' => $client_response->Customer->Street2,
            'city' => $client_response->Customer->City,
            'state' => $client_response->Customer->State,
            'postal_code' => $client_response->Customer->PostalCode,
            'country' => $client_response->Customer->Country,
            'email' => $client_response->Customer->Email,
            'phone' => $client_response->Customer->Phone,
            'mobile' => $client_response->Customer->Mobile,
            'comments' => $client_response->Customer->Comments,
            'fax' => $client_response->Customer->Fax,
            'url' => $client_response->Customer->Url,

        ]);

        if ($client_response->TransactionStatus) {
            //send response 
            return response()->json([

                'key' => 'success',
                'transaction_id' => $client_response->TransactionID,
                'message' => 'Payment Completed Successfully'
            ], 201);
        } else {
            echo "Transaction declined";
        }
    }


    // store paypal info in payment history table and send response
    public function paypalPayemntResponse(Request $request)
    {

        //get the response 
        //$response = Http::get('http://example.com');
        //$response_body = $response->body();

        $user_id = 1; //it will come from api
        $lead_id = 1; //it will come from api

       $client_response = '{
        create_time: '2022-09-29T10:59:10Z', update_time: '2022-09-29T10:59:22Z', id: '5PC23671CH936720Y', intent: 'CAPTURE', status: 'COMPLETED', …}
                        create_time
                        : 
                        "2022-09-29T10:59:10Z"
                        id
                        : 
                        "5PC23671CH936720Y"
                        intent
                        : 
                        "CAPTURE"
                        links
                        : 
                        Array(1)
                        0
                        : 
                        href
                        : 
                        "https://api.sandbox.paypal.com/v2/checkout/orders/5PC23671CH936720Y"
                        method
                        : 
                        "GET"
                        rel
                        : 
                        "self"
                        title
                        : 
                        "GET"
                        [[Prototype]]
                        : 
                        Object
                        length
                        : 
                        1
                        [[Prototype]]
                        : 
                        Array(0)
                        payer
                        : 
                        address
                        : 
                        country_code
                        : 
                        "US"
                        [[Prototype]]
                        : 
                        Object
                        email_address
                        : 
                        "sb-vouos20396551@personal.example.com"
                        name
                        : 
                        given_name
                        : 
                        "John"
                        surname
                        : 
                        "Doe"
                        [[Prototype]]
                        : 
                        Object
                        payer_id
                        : 
                        "GGHH982LV896Q"
                        [[Prototype]]
                        : 
                        Object
                        purchase_units
                        : 
                        Array(1)
                        0
                        : 
                        amount
                        : 
                        currency_code
                        : 
                        "AUD"
                        value
                        : 
                        "10.00"
                        [[Prototype]]
                        : 
                        Object
                        description
                        : 
                        "RLP Course"
                        payee
                        : 
                        email_address
                        : 
                        "sb-m8tew18060772@business.example.com"
                        merchant_id
                        : 
                        "2JKYQG6QNCHCE"
                        [[Prototype]]
                        : 
                        Object
                        payments
                        : 
                        captures
                        : 
                        [{…}]
                        [[Prototype]]
                        : 
                        Object
                        reference_id
                        : 
                        "default"
                        shipping
                        : 
                        address
                        : 
                        address_line_1
                        : 
                        "1 Main St"
                        admin_area_1
                        : 
                        "CA"
                        admin_area_2
                        : 
                        "San Jose"
                        country_code
                        : 
                        "US"
                        postal_code
                        : 
                        "95131"
                        [[Prototype]]
                        : 
                        Object
                        name
                        : 
                        full_name
                        : 
                        "John Doe"
                        [[Prototype]]
                        : 
                        Object
                        [[Prototype]]
                        : 
                        Object
                        [[Prototype]]
                        : 
                        Object
                        length
                        : 
                        1
                        [[Prototype]]
                        : 
                        Array(0)
                        status
                        : 
                        "COMPLETED"
                        update_time
                        : 
                        "2022-09-29T10:59:22Z"
                            }';

        PaymentHistory::create([

       /*      'payment_method' => 'Paypal',
            'payment_amount' => $client_response->TotalAmount,
            'user_id' => $user_id, //it will come from api
            'payment_status' => $client_response->TransactionStatus,
            'payment_log' => json_encode($client_response),
            'lead_id' => $lead_id, ////it will come from api
            'Authorisation_code' => $client_response->AuthorisationCode,
            'response_code' => $client_response->ResponseCode,
            'response_msg' => $client_response->ResponseMessage,
            'invoice_number' => $client_response->InvoiceNumber,
            'invoice_ref' => $client_response->InvoiceReference,
            'transaction_id' => $client_response->TransactionID,
            'first_name' => $client_response->Customer->FirstName,
            'last_name' => $client_response->Customer->LastName,
            'company_name' => $client_response->Customer->CompanyName,
            'job_description' => $client_response->Customer->JobDescription,
            'street1' => $client_response->Customer->Street1,
            'street2' => $client_response->Customer->Street2,
            'city' => $client_response->Customer->City,
            'state' => $client_response->Customer->State,
            'postal_code' => $client_response->Customer->PostalCode,
            'country' => $client_response->Customer->Country,
            'email' => $client_response->Customer->Email,
            'phone' => $client_response->Customer->Phone,
            'mobile' => $client_response->Customer->Mobile,
            'comments' => $client_response->Customer->Comments,
            'fax' => $client_response->Customer->Fax,
            'url' => $client_response->Customer->Url, */

        ]);

        if ($client_response->TransactionStatus) {
            //send response 
            return response()->json([

                'key' => 'success',
                'transaction_id' => $client_response->TransactionID,
                'message' => 'Payment Completed Successfully'
            ], 201);
        } else {
            echo "Transaction declined";
        }
    }
}
