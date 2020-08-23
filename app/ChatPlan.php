<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatPlan extends Model
{
    protected $fillable = ['name','amount','message','access_day'];
}
