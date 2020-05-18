<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\CategoryTrack;
use App\CategoryTrackLog;

class CategoryTrackController extends Controller
{

  /*
  * Category Track
  */

  public function categoryTrack(Request $request){

    if(!$request->category_id){
      return response()->json(['message'=>'failed']);
    }

    $today_date = date("Y-m-d");
    $category_id = $request->category_id;

    //Check Tracking
    $check_tracking = CategoryTrack::where('category_id',$category_id)
    ->where('date',$today_date)->first();

    if($check_tracking){
      //Update Current Tracking
      $tracking = CategoryTrack::where('id',$check_tracking->id);
      $tracking->increment('click_count');

      //check log for unique
      $check_log = CategoryTrackLog::where('category_id',$category_id)
      ->where('user_ip',$request->getClientIp())
      ->first();

      if(!$check_log){
        $tracking->increment('click_count_unique');
      }

    }else{
      //Create New Tracking
      $tracking = CategoryTrack::create([
        'category_id'=>$category_id,
        'date'=>$today_date,
        'click_count'=>1,
        'click_count_unique'=>1
      ]);
    }

    //Tracking add log
    CategoryTrackLog::firstOrCreate([
      'category_id'=>$category_id,
      'user_ip'=>$request->getClientIp()
    ]);


    return response()->json(['message'=>'success']);
  }


}
