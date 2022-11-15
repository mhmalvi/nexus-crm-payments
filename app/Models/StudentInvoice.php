<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInvoice extends Model
{
    use HasFactory;

    protected $table ='student_invoice';
    protected $guarded = [];
//    protected $fillable = [
//        'invoice_id',
//        'transaction_id',
//        'lead_id',
//        'company_id',
//        'user_id',
//        'company_name',
//        'company_logo',
//        'course_code',
//        'course_title',
//        'payment_amount',
//        'payment_method',
//        'student_name',
//        'student_email',
//        'company_email',
//        'company_contact'
//    ];

}
