<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountCoupan extends Model
{
    protected $fillable = ['name','code','description','term','image','percentage','coupan_exp_time','product_id'];
}
