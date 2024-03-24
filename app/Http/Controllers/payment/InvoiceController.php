<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Services\stripe\GetInvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoice;
    public function __construct(GetInvoiceService $invoice){
        $this->invoice = $invoice;
    }
    public function generatePDF(Request $request)
    {
            $response = $this->invoice->generate_invoice($request->inv_id);
            dd($response->lines->data[0]->amount);
            $fileName = 'invoice-' . $student->student_name . '.pdf';
            $data = [
            'price' => $price,
            'company_name' => $response->customer_name,
            ];
            $pdf = PDF::loadView('myPDF', $data);
            $content = $pdf->download()->getOriginalContent();
            $invoice_number = random_int(10000, 99999);
            $invoice = Storage::put('public/invoice/' . $fileName, $content);
            // dd($invoice);

            // dd(json_encode($invoice_date));
            $student_invoice_exist = StudentInvoice::where('student_id', $student->id)->first();
            // dd($student_invoice_exist);
            // if($student_invoice_exist){
            // $student_invoice_exist->invoice_number=$student_invoice_exist->invoice_number;
            // $student_invoice_exist->student_name = $student->student_name;
            // $student_invoice_exist->file_path = 'https://crmbtob.quadque.digital/storage/app/public/invoice/'.$fileName;
            // $student_invoice_exist->course_fee = $request->price;
            // $student_invoice_exist->agency_id = $student->user_id;
            // $student_invoice_exist->student_id = $student->id;
            // $student_invoice_exist->invoice_date = $invoice_date;
            // $student_invoice = $student_invoice_exist->save();
            // }else{
            if ($invoice == true) {
                $student_invoice = StudentInvoice::create([
                    'invoice_number' => $invoice_number,
                    'student_name' => $student->student_name,
                    'file_path' => 'https://crmbtob.quadque.digital/storage/app/public/invoice/' . $fileName,
                    'course_fee' => $request->price,
                    'agency_id' => $student->user_id,
                    'student_id' => $student->id,
                    'invoice_date' => $invoice_date
                ]);

                if ($student_invoice) {
                    return response()->json([
                        'message' => 'Invoice generated',
                        'status' => 201,
                        'data' => $student_invoice
                    ], 201);
                }
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500,
                ], 500);
            }
            // }

        // }
        // dd(storage_path('app/public/invoice/'.$fileName.'.pdf'));

    }
}
