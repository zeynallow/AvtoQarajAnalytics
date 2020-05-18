<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarSearchTrack extends Model
{

  protected $fillable = ['car_type_id','car_make_id','car_model_id','car_generation_id','date','click_count','click_count_unique'];

  protected $with = ['car_type','car_make','car_model','car_generation'];


  public function car_type(){
    return $this->belongsTo('App\CarType','car_type_id');
  }

  public function car_make(){
    return $this->belongsTo('App\CarMake','car_make_id');
  }

  public function car_model(){
    return $this->belongsTo('App\CarModel','car_model_id');
  }

  public function car_generation(){
    return $this->belongsTo('App\CarGeneration','car_generation_id');
  }

}
