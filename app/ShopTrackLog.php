<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopTrackLog extends Model
{
  protected $fillable = ['shop_id','user_ip'];
}
