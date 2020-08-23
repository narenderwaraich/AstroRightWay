<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model
{
    protected $fillable = ['user_id','discount','tax','invoice_number','subtotal','net_amount','ship_charge','tax_rate'];
}
