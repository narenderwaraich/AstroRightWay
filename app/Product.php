<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','price','image','category_id','product_types_id','description','status','qty','stock','original_price','image1','image2','image3','image4'];
    
}
