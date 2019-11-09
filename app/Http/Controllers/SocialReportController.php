<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SocialReport;
use App\Shop;

class SocialReportController extends Controller
{

  /*
  Report Status
  1 = Pending
  2 = Partner Cancelled
  3 = Partner Replied
  4 = Staff Replied
  5 = Staff Cancelled
  */

  /*
  Status
  0 = Pending
  1 = Approve
  */

  public function index(Request $request){
    $reports = SocialReport::orderBy('status','asc')
    ->paginate(10);
    return view('app.social_reports.index',compact('reports'));
  }

  public function create(Request $request){
    $shops = Shop::all();
    return view('app.social_reports.create',compact('shops'));
  }

  public function store(Request $request){

    $request->validate([
      'client_contact'=>'required',
      'client_name'=>'required',
      'shop_id'=>'required'
    ]);

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
  * cancelRequest
  */
  public function cancelRequest($request_id){
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>2, // or 5 - shop
      'status'=>1
    ]);
    return redirect()->back();
  }

  /*
  * confirmRequest
  */
  public function confirmRequest($request_id){
    $reports = SocialReport::where('id',$request_id)
    ->update([
      'report_status'=>4, // or 3 - shop
      'status'=>1
    ]);
    return redirect()->back();
  }



}
