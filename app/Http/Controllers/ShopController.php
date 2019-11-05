<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ShopTrackExport;
use App\Exports\ShopCategoryTrackExport;
use App\ShopTrack;
use App\ShopCategoryTrack;
use App\Shop;
use DB;
use DateTime;
use Auth;

class ShopController extends Controller
{

  public function index(Request $request){

    $user = Auth::user();

    $result=NULL;

    if($request->date_range){

      if(!$request->date_range){
        return redirect()->back()->with('error','Tarixlər qeyd olunmayıb');
      }

      $date_range = explode('-',$request->date_range);
      $start_date = trim($date_range[0].'-'.$date_range[1].'-'.$date_range[2]);
      $end_date = trim($date_range[3].'-'.$date_range[4].'-'.$date_range[5]);

      //check export period
      $datetime1 = new DateTime($start_date);
      $datetime2 = new DateTime($end_date);
      $interval = $datetime1->diff($datetime2);
      $days = $interval->format('%a');

      if($days > 60){
        return redirect()->back()->with('error','Müddət 60 gündən çox olmamalıdır');
      }

      $_result = ShopTrack::select(
        'shop_id',
        DB::raw('SUM(click_count) AS sum_click_count'),
        DB::raw('SUM(click_count_unique) AS sum_click_count_unique')
        )
        ->whereBetween('date', [$start_date, $end_date]);


        if($user->role_id == 1){
          if($request->shop_id != "all"){
            $_result->where('shop_id',$request->shop_id);
          }
        }elseif($user->role_id == 2){
          $_result->where('shop_id',$user->shop_id);
        }



        $_result->orderBy('sum_click_count','desc');
        $_result->groupBy('shop_id');

        if($request->get('export') && $request->get('export') == 'excel'){
          $result = $_result->get();
        }else{
          $result = $_result->paginate(10);
          $result->appends(request()->query());
        }

      }


      $shops = Shop::all();

      if($request->get('export') && $request->get('export') == 'excel'){
        return (new ProductTrackExport($result->toArray()))->download('shops_export.xlsx');
      }else{
        return view('app.shops.index',compact('result','shops'));
      }

    }


  public function categories(Request $request){
    $user = Auth::user();
    $result=NULL;

    if($request->date_range){

      if(!$request->date_range){
        return redirect()->back()->with('error','Tarixlər qeyd olunmayıb');
      }

      $date_range = explode('-',$request->date_range);
      $start_date = trim($date_range[0].'-'.$date_range[1].'-'.$date_range[2]);
      $end_date = trim($date_range[3].'-'.$date_range[4].'-'.$date_range[5]);

      //check export period
      $datetime1 = new DateTime($start_date);
      $datetime2 = new DateTime($end_date);
      $interval = $datetime1->diff($datetime2);
      $days = $interval->format('%a');

      if($days > 60){
        return redirect()->back()->with('error','Müddət 60 gündən çox olmamalıdır');
      }

      $_result = ShopCategoryTrack::select(
        'category_id',
        'shop_id',
        DB::raw('SUM(click_count) AS sum_click_count'),
        DB::raw('SUM(click_count_unique) AS sum_click_count_unique')
        )
        ->whereBetween('date', [$start_date, $end_date]);


        if($user->role_id == 1){
          if($request->shop_id != "all"){
            $_result->where('shop_id',$request->shop_id);
          }
        }elseif($user->role_id == 2){
          $_result->where('shop_id',$user->shop_id);
        }


        $_result->orderBy('sum_click_count','desc');
        $_result->groupBy('category_id','shop_id');

        if($request->get('export') && $request->get('export') == 'excel'){
          $result = $_result->get();
        }else{
          $result = $_result->paginate(10);
          $result->appends(request()->query());
        }

      }

      $shops = Shop::all();

      if($request->get('export') && $request->get('export') == 'excel'){
        return (new ShopCategoryTrackExport($result->toArray()))->download('shop_categories_export.xlsx');
      }else{
        return view('app.shops.categories',compact('result','shops'));
      }

  }


}
