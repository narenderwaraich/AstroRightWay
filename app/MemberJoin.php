<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberJoin extends Model
{
    protected $fillable = ['name','phone_no','email','status','join_date','exp_date','member_code','refer_code','level','down_member','user_id'];
}
