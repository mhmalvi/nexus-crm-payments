<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'api_key',
        'api_password',
        'payment_method'
    ];
}
