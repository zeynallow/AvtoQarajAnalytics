<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopTrack extends Model
{
  protected $fillable = ['shop_id','date','click_count','click_count_unique'];

  protected $with = ['shop'];

  public function shop(){
    return $this->belongsTo('App\Shop','shop_id');
  }

}
