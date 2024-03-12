<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetails extends Model
{
    use HasFactory;
    protected $guarded=[];
    // protected $casts = [
    //     'email'=>'string',
    //     'client_id'=>'integer',
    //     'user_id'=>'integer',
    //     'card_number'=>'integer',
    //     'exp_date'=>'string',
    //     'cvc'=>'integer',
    // ];
}
