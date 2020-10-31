<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfitSharePayment extends Model
{
    protected $fillable = ['order_id','amount','user_id','astrologer_id','astrologer_security','astrologer_msg_profit','order_profit','message_payment','member_payment'];
}
