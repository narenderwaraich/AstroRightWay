<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionImage extends Model
{
    protected $fillable = ['page_name','section','bg_img','section_heading','section_sub_heading','section_content'];
}
