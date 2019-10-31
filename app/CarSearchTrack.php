<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarSearchTrack extends Model
{

  protected $fillable = ['car_type_id','car_make_id','car_model_id','car_generation_id','date','click_count','click_count_unique'];

}
