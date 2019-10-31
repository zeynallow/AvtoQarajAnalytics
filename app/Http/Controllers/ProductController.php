<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTrack;
use DB;

class ProductController extends Controller
{

  public function index(Request $request){

    $result=NULL;

    if($request->has('submit')){

      if(!$request->date_range){
        return redirect()->back()->with('error','Tarixlər qeyd olunmayıb');
      }

      if($request->product_source && $request->product_source == 2 && !$request->shop_id){
        return redirect()->back()->with('error','Mağaza seçilməyib');
      }

      $date_range = explode('-',$request->date_range);
      $start_date = trim($date_range[0].'-'.$date_range[1].'-'.$date_range[2]);
      $end_date = trim($date_range[3].'-'.$date_range[4].'-'.$date_range[5]);

      $_result = ProductTrack::select(
        'product_id',
        'shop_id',
        DB::raw('SUM(click_count) AS sum_click_count'),
        DB::raw('SUM(click_count_unique) AS sum_click_count_unique')
        )
        ->whereBetween('date', [$start_date, $end_date]);


        if($request->product_source == 2){ //shop
          if($request->shop_id == "all"){
            $_result->where('shop_id','!=',0); //all shop
          }else{
            $_result->where('shop_id',$request->shop_id);
          }
        }elseif($request->product_source == 3){ //other
          $_result->where('shop_id',0);
        }

        $_result->orderBy('sum_click_count','desc');
        $_result->groupBy('product_id','shop_id');
        $result = $_result->paginate(10);
      }


      $product_sources = [
        '1'=>'Hamısı',
        '2'=>'Mağazalar',
        '3'=>'Digər'
      ];

      $shops = [
        'all'=>'Bütün mağazalar',
        '1'=>'mercedes',
        '2'=>'bmw'
      ];

      return view('app.products.index',compact('result','product_sources','shops'));
    }

  }
