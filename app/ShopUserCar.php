<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopUserCar extends Model
{
  protected $fillable = ['user_id','id_car_type','id_car_make'];


  public function user(){
    return $this->belongsTo('App\User','user_id');
  }

  public function car_type(){
    return $this->belongsTo('App\CarType','id_car_type');
  }

  public function car_make(){
    return $this->belongsTo('App\CarMake','id_car_make');
  }




}
