<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundPayment extends Model
{
    protected $fillable = ['order_id','amount','transaction_id','status','transaction_date','user_id','message','refund_id','order_number'];
}
