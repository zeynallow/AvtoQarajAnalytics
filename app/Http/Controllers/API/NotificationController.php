<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\OneSignal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function storePlayerId(Request $request){
        $rules = [
            'player_id' => 'required|string'
        ];
        $messages = [
            'required' => 'Player id tələb olunur',
            'string' => 'Yalnış format',
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if($validator->fails()){
            return response()->json([
                'message' => 'error',
                'data' => [
                    'errors' => $validator->getMessageBag()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        OneSignal::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'player_id' => $request->player_id
            ]
        );

        return response()->json([
            'message' => 'success',
            'data' => []
        ], Response::HTTP_CREATED);
    }
}
