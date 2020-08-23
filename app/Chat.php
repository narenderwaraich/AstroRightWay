<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
   protected $fillable = ['user_message','reply_message','message_status','message_assign','user_id'];
}
