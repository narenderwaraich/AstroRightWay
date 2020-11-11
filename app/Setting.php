<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['admin_mail','tax_rate','ship_charge','astrologer','talk_per_min','talk_15','talk_30','coupan_exp_time','navbar_background_color','navbar_text_color','navbar_text_hover_color','heading_color','sub_heading_color','link_color','button_color','button_text_color','button_hover_color','button_hover_text_color','button_border_hover_color','button_border_color','member','astrologer_profit_share'];
}
