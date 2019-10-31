<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTrack extends Model
{
  protected $fillable = ['product_id','shop_id','date','click_count','click_count_unique'];

}
