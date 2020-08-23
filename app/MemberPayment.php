<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    protected $fillable = [
    	'order_id','transaction_id','bank_transaction_id','payment_method','bank_name','transaction_status','amount','transaction_date','user_id','member_id'];
}
