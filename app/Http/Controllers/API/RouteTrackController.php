<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\RouteTrack;
use App\RouteTrackLog;

class RouteTrackController extends Controller
{
  /*
  * Route Track
  */

  public function routeTrack(Request $request){

    $today_date = date("Y-m-d");
    $route = $request->route;

    //Check Tracking
    $check_tracking = RouteTrack::where('route',$route)
    ->where('date',$today_date)->first();

    if($check_tracking){
      //Update Current Tracking
      $tracking = RouteTrack::where('id',$check_tracking->id);
      $tracking->increment('click_count');

      //check log for unique
      $check_log = RouteTrackLog::where('route',$route)
      ->where('user_ip',$request->getClientIp())
      ->first();

      if(!$check_log){
        $tracking->increment('click_count_unique');
      }

    }else{
      //Create New Tracking
      $tracking = RouteTrack::create([
        'route'=>$route,
        'date'=>$today_date,
        'click_count'=>1,
        'click_count_unique'=>1
      ]);
    }

    //Tracking add log
    RouteTrackLog::firstOrCreate([
      'route'=>$route,
      'user_ip'=>$request->getClientIp()
    ]);


    return response()->json(['message'=>'success']);
  }

}
