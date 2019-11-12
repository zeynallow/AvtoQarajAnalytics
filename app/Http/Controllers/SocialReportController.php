<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SocialReport;
use App\Shop;
use Auth;

class SocialReportController extends Controller
{

  /*
  Report Status
  0 = Incomplete
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

  public function index(Request $request){
    $reports = SocialReport::orderBy('status','asc')
    ->where('report_status','!=',6)
    ->where('report_status','!=',7)
    ->paginate(10);
    return view('app.social_reports.index',compact('reports'));
  }

  public function create(Request $request){
    $shops = Shop::all();
    return view('app.social_reports.create',compact('shops'));
  }

  public function store(Request $request){

    $request->validate([
      'client_name'=>'required',
      'shop_id'=>'required'
    ],
    [
      'client_name.required'=>'Müştərinin adını qeyd edin',
      'shop_id.required'=>'Mağaza seçilməyib'
    ]);

    if(empty($request->client_contact)){
      $report_status = 0;//Incomplete
    }else{
      $report_status = 1; //Pending
    }

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
      'report_status'=>$report_status,
      'status'=>0
    ]);

    if($store){
      return redirect()->back()->with('success','Müraciət əlavə olundu');
    }else{
      return redirect()->back()->with('error','Səhv baş verdi');
    }


  }


  public function reports(Request $request){
    return view('app.social_reports.reports');
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
  * addClientContact
  */
  public function addClientContact(Request $request,$request_id){

    $user_role = Auth::user()->role_id;

    if($user_role == 2){
      return redirect()->back();
    }

    if(empty($request->client_contact)){
      return redirect()->back();
    }

    $reports = SocialReport::where('id',$request_id)
    ->update([
      'client_contact'=>$request->client_contact,
      'report_status'=>1, //pending
      'status'=>1
    ]);

    return redirect()->back();
  }
  /*
  * cancelRequest
  */
  public function cancelRequest($request_id){

    $user_role = Auth::user()->role_id;

    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>($user_role == 2) ? 2 : 5,
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
  public function confirmRequest($request_id){
    $user_role = Auth::user()->role_id;
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>($user_role == 2) ? 3 : 4,
      'status'=>1
    ]);
    return redirect()->back();
  }



}
