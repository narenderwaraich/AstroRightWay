<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id','order_number','transaction_id','method','subtotal','total','tax','tax_rate','ship_charge','discount','code','track_code','track_url','net_amount','status','user_id'];
}
