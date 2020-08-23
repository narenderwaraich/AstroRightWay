<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
	protected $fillable = ['amount','user_id','plan_id','access_date','is_activated','expire_date','get_message'];
}