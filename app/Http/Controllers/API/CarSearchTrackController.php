<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\CarSearchTrack;
use App\CarSearchTrackLog;

class CarSearchTrackController extends Controller
{

  /*
  * Car Search Track
  */

  public function carSearchTrack(Request $request){

    $today_date = date("Y-m-d");
    $car_type_id = $request->car_type_id;
    $car_make_id = $request->car_make_id;
    $car_model_id = $request->car_model_id;
    $car_generation_id = $request->car_generation_id;


    //Check Tracking
    $check_tracking = CarSearchTrack::where('car_type_id',$car_type_id)
    ->where('car_make_id',$car_make_id)
    ->where('car_model_id',$car_model_id)
    ->where('car_generation_id',$car_generation_id)
    ->where('date',$today_date)->first();

    if($check_tracking){
      //Update Current Tracking
      $tracking = CarSearchTrack::where('id',$check_tracking->id);
      $tracking->increment('click_count');

      //check log for unique
      $check_log = CarSearchTrackLog::where('car_type_id',$car_type_id)
      ->where('car_make_id',$car_make_id)
      ->where('car_model_id',$car_model_id)
      ->where('car_generation_id',$car_generation_id)
      ->where('user_ip',$request->getClientIp())
      ->first();

      if(!$check_log){
        $tracking->increment('click_count_unique');
      }

    }else{
      //Create New Tracking
      $tracking = CarSearchTrack::create([
        'car_type_id'=>$car_type_id,
        'car_make_id'=>$car_make_id,
        'car_model_id'=>$car_model_id,
        'car_generation_id'=>$car_generation_id,
        'date'=>$today_date,
        'click_count'=>1,
        'click_count_unique'=>1
      ]);
    }

    //Tracking add log
    CarSearchTrackLog::firstOrCreate([
      'car_type_id'=>$car_type_id,
      'car_make_id'=>$car_make_id,
      'car_model_id'=>$car_model_id,
      'car_generation_id'=>$car_generation_id,
      'user_ip'=>$request->getClientIp()
    ]);


    return response()->json(['message'=>'success']);
  }


}
