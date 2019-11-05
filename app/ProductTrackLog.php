<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTrackLog extends Model
{
  protected $fillable = ['product_id','user_ip'];
}
