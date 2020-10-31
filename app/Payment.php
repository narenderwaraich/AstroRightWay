<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   protected $fillable = ['order_number','order_id','payment_method','amount','transaction_id','transaction_status','bank_transaction_id','transaction_date','user_id','bank_name'];
}
