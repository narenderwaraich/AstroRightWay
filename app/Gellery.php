<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gellery extends Model
{
    protected $fillable = ['url','description','auth','title','image'];
}
