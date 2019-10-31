<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\ShopTrack;
use App\ShopTrackLog;
use App\ShopTypeTrack;
use App\ShopTypeTrackLog;
use App\ShopCategoryTrack;
use App\ShopCategoryTrackLog;

class ShopTrackController extends Controller
{

  /*
  * Shop Track
  */
  public function shopTrack(Request $request){

    $today_date = date("Y-m-d");
    $shop_id = $request->shop_id;

    //Check Tracking
    $check_tracking = ShopTrack::where('shop_id',$shop_id)
    ->where('date',$today_date)->first();

    if($check_tracking){
      //Update Current Tracking
      $tracking = ShopTrack::where('id',$check_tracking->id);
      $tracking->increment('click_count');

      //check log for unique
      $check_log = ShopTrackLog::where('shop_id',$shop_id)
      ->where('user_ip',$request->getClientIp())
      ->first();

      if(!$check_log){
        $tracking->increment('click_count_unique');
      }

    }else{
      //Create New Tracking
      $tracking = ShopTrack::create([
        'shop_id'=>$shop_id,
        'date'=>$today_date,
        'click_count'=>1,
        'click_count_unique'=>1
      ]);
    }

    //Tracking add log
    ShopTrackLog::firstOrCreate([
      'shop_id'=>$shop_id,
      'user_ip'=>$request->getClientIp()
    ]);


    return response()->json(['message'=>'success']);
  }

  /*
  * Shop Category Track
  */

  public function shopCategoryTrack(Request $request){

    $today_date = date("Y-m-d");
    $category_id = $request->category_id;
    $shop_id = $request->shop_id;

    //Check Tracking
    $check_tracking = ShopCategoryTrack::where('category_id',$category_id)
    ->where('shop_id',$shop_id)
    ->where('date',$today_date)->first();

    if($check_tracking){
      //Update Current Tracking
      $tracking = ShopCategoryTrack::where('id',$check_tracking->id);
      $tracking->increment('click_count');

      //check log for unique
      $check_log = ShopCategoryTrackLog::where('category_id',$category_id)
      ->where('shop_id',$shop_id)
      ->where('user_ip',$request->getClientIp())
      ->first();

      if(!$check_log){
        $tracking->increment('click_count_unique');
      }

    }else{
      //Create New Tracking
      $tracking = ShopCategoryTrack::create([
        'category_id'=>$category_id,
        'shop_id'=>$shop_id,
        'date'=>$today_date,
        'click_count'=>1,
        'click_count_unique'=>1
      ]);
    }

    //Tracking add log
    ShopCategoryTrackLog::firstOrCreate([
      'category_id'=>$category_id,
      'shop_id'=>$shop_id,
      'user_ip'=>$request->getClientIp()
    ]);


    return response()->json(['message'=>'success']);
  }


}
