<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CarSearchTrackExport;
use App\CarSearchTrack;
use App\Shop;
use DB;
use Auth;
use DateTime;

class CarSearchController extends Controller
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

      $_result = CarSearchTrack::select(
        'car_type_id',
        'car_make_id',
        'car_model_id',
        'car_generation_id',
        DB::raw('SUM(click_count) AS sum_click_count'),
        DB::raw('SUM(click_count_unique) AS sum_click_count_unique')
        )
        ->whereBetween('date', [$start_date, $end_date]);


        if($user->role_id == 2){

          $user_shop_car_types = [];
          $user_shop_car_makes = [];

          foreach ($user->shop_cars as $key => $user_shop_car) {
            $user_shop_car_types[]=$user_shop_car->id_car_type;
            $user_shop_car_makes[]=$user_shop_car->id_car_make;
          }

          $_result->whereIn('car_type_id',$user_shop_car_types);
          $_result->whereIn('car_make_id',$user_shop_car_makes);

        }

        $_result->orderBy('sum_click_count','desc');
        $_result->groupBy('car_type_id','car_make_id','car_model_id','car_generation_id');

        if($request->get('export') && $request->get('export') == 'excel'){
          $result = $_result->get();
        }else{
          $result = $_result->paginate(10);
          $result->appends(request()->query());
        }
      }


      if($request->get('export') && $request->get('export') == 'excel'){
        return (new CarSearchTrackExport($result->toArray()))->download('car_search_export_'.$start_date.'-'.$end_date.'.xlsx');
      }else{
        return view('app.car_searches.index',compact('result'));
      }

    }


  }
