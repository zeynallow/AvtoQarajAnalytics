<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopUserCar extends Model
{
  protected $fillable = ['shop_id','id_car_type','id_car_make'];

  public function shop(){
    return $this->belongsTo('App\Shop','shop_id');
  }

  public function car_type(){
    return $this->belongsTo('App\CarType','id_car_type');
  }

  public function car_make(){
    return $this->belongsTo('App\CarMake','id_car_make');
  }




}
