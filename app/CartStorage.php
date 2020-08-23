<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartStorage extends Model
{
    protected $fillable = [
        'id', 'product_id','user_id','product_name','price','description','image','tax','tax_rate','qty','ship_charge','discount','subtotal','total','net_amount','coupan_code','discount_percentage'
    ];
}
