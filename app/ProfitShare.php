<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfitShare extends Model
{
    protected $fillable = ['total_profit','pay_profit','pending_profit','cal_profit_date','last_pay_profit_date'];
}
