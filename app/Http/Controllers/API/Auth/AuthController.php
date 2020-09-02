<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(){
        $credentials = request(['email', 'password']);
        if(! $token = auth()->guard('api')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function me(){
        return response()->json(auth()->guard('api')->user());
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
}
