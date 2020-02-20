<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\NewSocialRequest;
use Illuminate\Support\Facades\Notification;
use App\Exports\SocialReportExport;
use App\Product;
use App\SocialReport;
use App\SocialReportReply;
use App\SocialReportCancel;
use App\Shop;
use App\User;
use Auth;
use DB;
use DateTime;

class SocialReportController extends Controller
{

  /*
  Report Status
  8 = Incomplete
  1 = Pending
  2 = Partner Cancelled
  3 = Partner Replied
  4 = Staff Replied
  5 = Staff Cancelled
  6 = Staff Soft Delete
  7 = Partner Soft Delete
  */

  /*
  Status
  0 = Pending
  1 = Approve
  */

  /*
  * index
  */
  public function index(Request $request){
    $user = Auth::user();
    $_reports = SocialReport::orderBy('status','asc');
    $_reports->orderBy('created_at','desc');
    $_reports->where('report_status','!=',6);
    $_reports->where('report_status','!=',7);

    //filter
    if($request->get('query')){
      $s_query = $request->get('query');
      $_reports->where(function($query) use ($s_query){
        $query->where('client_contact','LIKE','%'.$s_query.'%');
        $query->orWhere('client_name','LIKE','%'.$s_query.'%');
      });
    }

    if($request->get('date_range')){
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

      $_reports->whereBetween('created_at', [$start_date, $end_date]);
    }

    if($request->get('shop_id')){
      $_reports->where('shop_id',$request->get('shop_id'));
    }



    if($user->role_id == 2){
      $_reports->where('shop_id',Auth::user()->shop_id);
    }

    $reports = $_reports->paginate(10);
    $reports->appends(request()->query());

    $shops = Shop::all();

    $cancels = SocialReportCancel::select('id as value','description as text')->get();
    $replies = SocialReportReply::select('id as value','description as text')->get();

    return view('app.social_reports.index',compact('shops','reports','cancels','replies'));
  }

  /*
  * create
  */
  public function create(Request $request){
    $shops = Shop::all();
    return view('app.social_reports.create',compact('shops'));
  }

  /*
  * Store
  */
  public function store(Request $request){

    // $request->validate([
    //   'shop_id'=>'required',
    // ],
    // [
    //   'shop_id.required'=>'Mağaza seçilməyib'
    // ]);

    // if(empty($request->client_contact)){
    //   $report_status = 8;//Incomplete
    // }else{
    //   $report_status = 1; //Pending
    // }

    $store = SocialReport::create([
      'network_type'=>$request->network_type,
      'product_id'=>$request->product_id,
      'product_name'=>$request->product_name,
      'shop_id'=>$request->shop_id,
      'client_name'=>$request->client_name,
      'client_contact'=>$request->client_contact,
      'client_comment'=>$request->client_comment,
      'client_auto_car'=>$request->client_auto_car,
      'client_auto_year'=>$request->client_auto_year,
      'client_auto_vin'=>$request->client_auto_vin,
      'partner_comment'=>$request->partner_comment,
      'report_status'=>1,
      'username'=>$request->username,
      'status'=>0
    ]);

    if($store){
      $notify_users = User::where('shop_id',$request->shop_id)->get();

      if($notify_users && count($notify_users)){
        $detectTempEmail = explode("@avtoqaraj.az",$notify_users[0]->email);
        if(count($detectTempEmail) != 2){
          Notification::send($notify_users, new NewSocialRequest($store));
        }
      }

      return redirect()->back()->with('success','Müraciət əlavə olundu');
    }else{
      return redirect()->back()->with('error','Səhv baş verdi');
    }


  }


  /*
  * getProductInfo
  */
  public function getProductInfo($product_id){

    if(empty($product_id) || $product_id < 1){
      return response()->json(['message'=>'error']);
    }

    $get = Product::select('id','shop_id','product_name')
    ->where('id',$product_id)
    ->firstOrFail();

    return response()->json($get);
  }

  /*
  * update
  */
  public function update(Request $request,$request_id){

    $user_role = Auth::user()->role_id;

    if($user_role == 2){
      return redirect()->back();
    }

    if(empty($request->client_contact)){
      return redirect()->back();
    }

    $reports = SocialReport::where('id',$request_id)
    ->update([
      'client_name'=>$request->client_name,
      'client_contact'=>$request->client_contact,
      'client_auto_car'=>$request->client_auto_car,
      'client_auto_year'=>$request->client_auto_year,
      'client_auto_vin'=>$request->client_auto_vin,
      'client_comment'=>$request->client_comment,
      'report_status'=>1, //pending
      'status'=>0
    ]);

    return redirect()->back();
  }
  /*
  * cancelRequest
  */
  public function cancelRequest($request_id,$description_id){

    $user_role = Auth::user()->role_id;

    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>($user_role == 2) ? 2 : 5,
      'cancel_description'=>$description_id,
      'status'=>1
    ]);

    return redirect()->back();
  }

  /*
  * changeCancelRequest
  */
  public function changeCancelRequest($request_id,$description_id){
    $user_role = Auth::user()->role_id;
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'reply_description'=>0,
      'cancel_description'=>$description_id,
      'status'=>1
    ]);
    return redirect()->back();
  }

  /*
  * Soft Delete
  */
  public function softDeleteRequest($request_id){
    $user_role = Auth::user()->role_id;
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>($user_role == 2) ? 7 : 6,
      'status'=>1
    ]);
    return redirect()->back();
  }

  /*
  * confirmRequest
  */
  public function confirmRequest($request_id,$description_id){
    $user_role = Auth::user()->role_id;
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>($user_role == 2) ? 3 : 4,
      'reply_description'=>$description_id,
      'status'=>1
    ]);
    return redirect()->back();
  }

  /*
  * changeConfirmRequest
  */
  public function changeConfirmRequest($request_id,$description_id){
    $user_role = Auth::user()->role_id;
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'reply_description'=>$description_id,
      'cancel_description'=>0,
      'status'=>1
    ]);
    return redirect()->back();
  }


  /*
  * reports
  */
  public function reports(Request $request){
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

      $_result = DB::table(function($query) use ($user,$start_date,$end_date,$request){

        $query->select(
          'network_type',
          'shop_id',
          'report_status',
          DB::raw('CASE WHEN report_status = 1 THEN 1 END AS pending'),
          DB::raw('CASE WHEN report_status = 2 THEN 1 END AS shop_cancel'),
          DB::raw('CASE WHEN report_status = 3 THEN 1 END AS shop_replied'),
          DB::raw('CASE WHEN report_status = 4 THEN 1 END AS garage_replied'),
          DB::raw('CASE WHEN report_status = 5 THEN 1 END AS garage_cancelled'),
          DB::raw('CASE WHEN report_status = 8 THEN 1 END AS client_pending')
          )->from('social_reports');

          $query->whereBetween('created_at', [$start_date, $end_date]);

          if($user->role_id == 1){
            if($request->shop_id == "all"){
              $query->where('shop_id','!=',0); //all shop
            }else{
              $query->where('shop_id',$request->shop_id);
            }
          }elseif($user->role_id == 2){
            $query->where('shop_id',$user->shop_id);
          }

        })->select(
          'shop_id',
          'network_type',
          DB::raw('SUM(pending) as pending'),
          DB::raw('SUM(shop_cancel) as shop_cancel'),
          DB::raw('SUM(shop_replied) as shop_replied'),
          DB::raw('SUM(garage_replied) as garage_replied'),
          DB::raw('SUM(garage_cancelled) as garage_cancelled'),
          DB::raw('SUM(client_pending) as client_pending')
        );

        $_result->groupBy('network_type','shop_id');

        if($request->get('export') && $request->get('export') == 'excel'){
          $result = $_result->get();
        }else{
          $result = $_result->paginate(10);
          $result->appends(request()->query());
        }

      }

      //==

      $shops = Shop::all();

      if($request->get('export') && $request->get('export') == 'excel'){
        return (new SocialReportExport($result->toArray()))->download("social_report_$start_date-$end_date.xlsx");
      }else{
        return view('app.social_reports.reports',compact('result','shops'));
      }
    }


  }
