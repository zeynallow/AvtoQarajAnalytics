<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RouteTrackExport;
use App\RouteTrack;
use DB;
use DateTime;

class RouteTrackController extends Controller
{


  public function index(Request $request){

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

      $_result = RouteTrack::select(
        'route',
        DB::raw('SUM(click_count) AS sum_click_count'),
        DB::raw('SUM(click_count_unique) AS sum_click_count_unique')
        )
        ->whereBetween('date', [$start_date, $end_date]);


        $_result->orderBy('sum_click_count','desc');
        $_result->groupBy('route');

        if($request->get('export') && $request->get('export') == 'excel'){
          $result = $_result->get();
        }else{
          $result = $_result->paginate(10);
          $result->appends(request()->query());
        }
      }


      if($request->get('export') && $request->get('export') == 'excel'){
        return (new RouteTrackExport($result->toArray()))->download('route_tracks_export_'.$start_date.'-'.$end_date.'.xlsx');
      }else{
        return view('app.route_tracks.index',compact('result'));
      }

    }


  }
