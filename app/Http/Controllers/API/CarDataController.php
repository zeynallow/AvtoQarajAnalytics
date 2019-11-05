<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\CarMake;
use Cache;

class CarDataController extends Controller
{

  /*
  * Get Makes
  */
  public function getMake($type_id){

    $data = Cache::remember("getMake.{$type_id}", 24*60, function() use ($type_id){
      return CarMake::where("id_car_type",$type_id)->orderBy('name','ASC')->get();
    });

    return response()->json($data,200,$headers = [],JSON_UNESCAPED_UNICODE);
  }
}
