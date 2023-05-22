<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $nextInvoiceNumber = date('dmY') . '-' . '1' . rand(111111, 999999);
            $invoice_is_exist = PaymentHistory::where('invoice_number', $nextInvoiceNumber)->exists();
            if (!$invoice_is_exist) {
                $save = PaymentHistory::create([
                    'payment_method' => 'manual',
                    'payer_id' => isset($request->payer_id) ? $request->payer_id : '',
                    'payment_amount' => isset($request->payment_amount) ? $request->payment_amount : '',
                    'user_id' => 1,
                    'company_id' => isset($request->company_id) ? $request->company_id : '',
                    'payment_status' => 'succeeded',
                    'lead_id' => isset($request->lead_id) ? $request->lead_id : '',
                    'authorisation_code' => isset($request->authorisation_code) ? $request->authorisation_code : null,
                    'response_code' => isset($request->response_code) ? $request->response_code : null,
                    'response_msg' => isset($request->response_msg) ? $request->response_msg : '',
                    'invoice_number' => $nextInvoiceNumber,
                    'transaction_id' => isset($request->transaction_id) ? $request->transaction_id : '',
                    'first_name' => isset($request->first_name) ? $request->first_name : '',
                    'last_name' => isset($request->last_name) ? $request->last_name : '',
                    'company_name' => isset($request->company_name) ? $request->company_name : '',
                    'street1' => isset($request->street1) ? $request->street1 : '',
                    'street2' => isset($request->street2) ? $request->street2 : '',
                    'city' => isset($request->city) ? $request->city : '',
                    'state' => isset($request->state) ? $request->state : '',
                    'postal_code' => isset($request->postal_code) ? $request->postal_code : '',
                    'country' => isset($request->country) ? $request->country : '',
                    'email' => isset($request->email) ? $request->email : '',
                    'phone' => isset($request->phone) ? $request->phone : '',
                    'mobile' => isset($request->mobile) ? $request->mobile : '',
                    'course_title' => isset($request->course_title) ? $request->course_title : '',
                    'course_code' => isset($request->course_code) ? $request->course_code : "",
                ]);
                if ($save) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => $save
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'failed to save',
                        'status' => 500
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'invoice number already exists',
                    'status' => 409
                ], 409);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $history = PaymentHistory::find($id);
            if ($history) {
                $flag = $history->delete();
                if ($flag) {
                    return response()->json([
                        'message' => 'deleted',
                        'status' => 200
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'failed',
                        'status' => 500
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
