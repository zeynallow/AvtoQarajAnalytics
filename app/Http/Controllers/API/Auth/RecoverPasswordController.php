<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\SendMail;
use App\Http\Controllers\Controller;
use App\OtpAuthentication;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecoverPasswordController extends Controller
{
    public function sendOtp(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $otp = $this->otpGenerator();
        $token = Str::random(60);

//        OtpAuthentication::create([
//            'otp' => $otp,
//            'email' => $request->email,
//            'token' => Str::random(60),
//        ]);

        OtpAuthentication::create([
            'otp' => 12345,
            'email' => $request->email,
            'token' => Str::random(60),
        ]);

//        Event::dispatch(new SendMail(
//            $request->email,
//            'Şifrə bərpa kodu',
//            $this->otpGenerator(),
//            'app.emails.otp'
//        ));

        return response()->json([
            'message' => 'success',
            'data' => ['token' => $token]
        ]);
    }

    public function recoverPassword(Request $request){
        $request->validate([
            'code' => 'required|max:6',
            'password' => 'required|confirmed',
            'otp_token' => 'required|string'
        ]);

        $otpAuth = OtpAuthentication::where(['token' => $request->token, 'expired' => OtpAuthentication::ACTIVE])->first();

        if($otpAuth){
            if($otpAuth->code != $request->code){
                $response = [
                    'message' => 'error',
                    'data' => 'OTP şifrə yalnışdır'
                ];
                $status = Response::HTTP_BAD_REQUEST;
            }
            User::where('email', $otpAuth->email)->update(['password' => Hash::make($request->password)]);
            $otpAuth->update(['expired' => OtpAuthentication::EXPIRED]);

            $response = [
                'message' => 'success',
            ];
            $status = Response::HTTP_CREATED;

        }else{
            $response = [
                'message' => 'error',
                'data' => 'Token yalnışdır və ya artıq aktiv deyil'
            ];
            $status = Response::HTTP_BAD_REQUEST;
        }

        return response()->json($response, $status);
    }

    public function otpGenerator(){
        $alphaNum = range('0','9');
        shuffle($alphaNum);
        $otp = '';
        for($i = 0; $i < 6; $i++){
            $otp .= $alphaNum[$i];
        }
        return $otp;
    }
}
