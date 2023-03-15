<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentHistory;

class Invoices extends Model
{
    use HasFactory;
    protected $table ='invoices';
    protected $guarded = [];

    public function paymentHistory(){
        return $this->belongsTo(PaymentHistory::class,'invoice_number','invoice_id');
    }
}
