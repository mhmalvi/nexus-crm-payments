<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use App\Models\PaymentSettings;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return Payment Setting
     */
    public function createSetting(Request $request)
    {
        if(!isset($request->user_id))
            return response()->json([
                'status' => false,
                'message' => 'User Id not found',
            ], 404);

        try {

            $data = PaymentSettings::updateOrcreate([
                'user_id' => $request->user_id,
                'company_id' => isset($request->company_id)?$request->company_id:'',
                'api_key' => isset($request->api_key)?$request->api_key:'',
                'api_password' => isset($request->api_password)?$request->api_password:'',
                'payment_method' => isset($request->payment_method)?$request->payment_method:''
            ])->toArray();

            return response()->json([
                'status' => true,
                'message' => 'Payment Setting Created Successfully',
                'data'  => $data
            ], 201);

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update User
     * @param Request $request
     * @return boolean
     */
    public function updatePaymentSetting(Request $request)
    {
        if(!isset($request->id))
            return response()->json([
                'status' => false,
                'message' => 'Id not found',
            ], 401);

        try {
            $paymentSetting = PaymentSettings::find($request->id)->first();
            if($paymentSetting==""){
                return response()->json([
                    'status' => false,
                    'message' => 'Payment Setting Data not found',
                ], 401);
            }
            if(isset($request->api_key))
                $paymentSetting->api_key = $request->api_key;
            if(isset($request->api_password))
                $paymentSetting->api_password = $request->api_password;
            if(isset($request->payment_method))
                $paymentSetting->payment_method = $request->payment_method;
            if(isset($request->payment_email))
                $paymentSetting->payment_email = $request->payment_email;
            $paymentSetting->save();
            return response()->json([
                'status' => true,
                'message' => 'Payment Setting Update Successfully',
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
