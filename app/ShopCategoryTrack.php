<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryTrack extends Model
{
    protected $fillable = ['category_id','shop_id','date','click_count','click_count_unique'];
    
}
