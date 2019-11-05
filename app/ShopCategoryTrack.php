<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryTrack extends Model
{
    protected $fillable = ['category_id','shop_id','date','click_count','click_count_unique'];

    protected $with = ['shop'];

    public function shop(){
      return $this->belongsTo('App\Shop','shop_id');
    }

    public function category(){
      return $this->belongsTo('App\Category','category_id');
    }

}
