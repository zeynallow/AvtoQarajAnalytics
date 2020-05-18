<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\ProductTrack;
use App\ProductTrackLog;

class ProductTrackController extends Controller
{

    public function productTrack(Request $request){

          $today_date = date("Y-m-d");
          $product_id = $request->product_id;
          $shop_id = $request->shop_id;

          //Check Tracking
          $check_tracking = ProductTrack::where('product_id',$product_id)
          ->where('date',$today_date)->first();

          if($check_tracking){
            //Update Current Tracking
            $tracking = ProductTrack::where('id',$check_tracking->id);
            $tracking->increment('click_count');

            //check log for unique
            $check_log = ProductTrackLog::where('product_id',$product_id)
            ->where('user_ip',$request->getClientIp())
            ->first();

            if(!$check_log){
              $tracking->increment('click_count_unique');
            }

          }else{
            //Create New Tracking
            $tracking = ProductTrack::create([
              'product_id'=>$product_id,
              'shop_id'=>$shop_id,
              'date'=>$today_date,
              'click_count'=>1,
              'click_count_unique'=>1
            ]);
          }

          //Tracking add log
          ProductTrackLog::firstOrCreate([
            'product_id'=>$product_id,
            'user_ip'=>$request->getClientIp()
          ]);


          return response()->json(['message'=>'success']);
    }

}
