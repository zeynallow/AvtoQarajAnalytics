<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTrack extends Model
{

  protected $fillable = ['product_id','shop_id','date','click_count','click_count_unique'];

  protected $with = ['product','shop'];

  
  public function product(){
    return $this->belongsTo('App\Product','product_id');
  }

  public function shop(){
    return $this->belongsTo('App\Shop','shop_id');
  }

}
