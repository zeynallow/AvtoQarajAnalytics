<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(){
        $credentials = request(['email', 'password']);
        if(! $token = auth()->guard('api')->attempt($credentials)){
            return response()->json(
                [
                    "message" => 'error',
                    "data" => [
                        'errors' =>
                        [
                            "login" => 'Unauthorized'
                        ]
                    ]
                ],
                Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function me(){
        return response()->json([
           'message' => 'success',
           'data' => new UserResource(auth()->guard('api')->user()->load('shop')),
        ],Response::HTTP_OK);
    }

    public function logout(){
        auth()->guard('api')->logout();
        return response()->json(['message' => 'Success']);
    }

    public function refresh(){
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
            'shop_id' => auth()->guard('api')->user()->shop_id
        ]);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|confirmed|string',
        ]);

        $user = auth()->guard('api')->user();
        if(!Hash::check($request->old_password, $user->password)){
            return response()->json([
                'message' => 'error',
                'data' => [
                    "errors" => [
                        "password" => 'Köhnə şifrə yalnışdır'
                    ]
                ]
            ]);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'message' => 'success',
            'data' => 'Logged in'
        ]);
    }
}
