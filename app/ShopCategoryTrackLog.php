<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryTrackLog extends Model
{
    protected $fillable = ['shop_id','category_id','user_ip'];
}
