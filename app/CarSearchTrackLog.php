<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarSearchTrackLog extends Model
{
  protected $fillable = ['car_type_id','car_make_id','car_model_id','car_generation_id','user_ip'];
}
