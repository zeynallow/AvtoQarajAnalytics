<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopReportResource;
use App\Http\Resources\ShopReportResourceCollection;
use App\SocialReport;
use App\SocialReportCancel;
use App\SocialReportReply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShopReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request, $shopId){
        $shopId = htmlentities(trim($shopId));

        $user = auth()->guard('api')->user();

        $_reports = SocialReport::orderBy('created_at','desc');
        $_reports->where('shop_id', $shopId);
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
                return response()->json([
                    'message' => 'error',
                    'data' => ['date' => 'Müddət 60 gündən çox olmamalıdır']
                ], Response::HTTP_BAD_REQUEST);
            }

            $_reports->whereBetween('created_at', [$start_date, $end_date]);
        }

        return response()->json([
            'message' => 'success',
            'data' => ShopReportResourceCollection::collection($_reports->with('get_report_status')->get())
        ], Response::HTTP_OK);
    }

    public function getReport($shopId, SocialReport $report){
        return response()->json([
            'message' => 'success',
            'data' => new ShopReportResource($report)
        ]);
    }

    public function sendAcceptMessages(){
        return response()->json([
            'message' => 'success',
            'data' => SocialReportReply::all()
        ]);
    }

    public function sendCancelMessages(){
        return response()->json([
            'message' => 'success',
            'data' => SocialReportCancel::all()
        ]);
    }

    public function changeReportStatus(Request $request, SocialReport $report){
        $request->validate([
            'descriptionId' => 'required|integer',
            'type' => 'required|integer'
        ]);

        $report_status = $request->type == SocialReport::TYPE_ACCEPT ? 3 : 2;
        $description_type_name = $request->type == SocialReport::TYPE_ACCEPT ? 'reply_description' : 'cancel_description';

        $report->update([
            $description_type_name => $request->descriptionId,
            'status' => 1,
            'report_status' => $report_status,
        ]);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
