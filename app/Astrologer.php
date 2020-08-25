<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Astrologer extends Model
{
    protected $fillable = ['name','phone_no','email','verified','email_token','date','gender','address','country','state','city','zipcode','avatar','password','total_amount','left_amount','bank_name','account_no','ifsc_code','upi_id','auth_id','chat_refer'];
}