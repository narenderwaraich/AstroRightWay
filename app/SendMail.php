<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
    protected $fillable = ['name','email','user_id','message','subject','created_at'];
}
