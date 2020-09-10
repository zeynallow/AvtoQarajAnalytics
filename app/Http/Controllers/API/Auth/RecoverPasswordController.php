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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecoverPasswordController extends Controller
{
    public function sendOtp(Request $request){
        $rules = [
            'email' => 'required|email',
        ];

        $messages = [
            'email.required' => 'Email tələb olunur.',
            'email' => 'Email yalnış formatdadır.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                'message' => 'error',
                'data' => [
                    'errors' => $validator->getMessageBag()
                ]
            ]);
        }

        $otp = $this->otpGenerator();
        $token = Str::random(60);

//        OtpAuthentication::create([
//            'otp' => $otp,
//            'email' => $request->email,
//            'token' => $token,
//        ]);

        OtpAuthentication::create([
            'otp' => 12345,
            'email' => $request->email,
            'token' => $token,
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
        $rules = [
            'code' => 'required',
            'password' => 'required|confirmed',
            'otp_token' => 'required|string'
        ];

        $messages = [
            'code.required' => 'Otp kod tələb olunur.',
            'password.required' => 'Şifrə tələb olunur.',
            'password.confirmed' => 'Şifrənin təsdiqi yalnışdır.',
            'otp_token.required' => 'Otp token tələb olunur.',
            'otp_token.string' => 'Otp token yalnış formatdadır.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                'message' => 'error',
                'data' => [
                    'errors' => $validator->getMessageBag()
                ]
            ]);
        }

        $otpAuth = OtpAuthentication::where(['token' => $request->otp_token, 'expired' => OtpAuthentication::ACTIVE])->first();

        if($otpAuth){
            if($otpAuth->code != $request->code){
                $response = [
                    'message' => 'error',
                    'data' => [
                        'errors' => [
                            'otp' => 'OTP şifrə yalnışdır'
                        ]
                    ]
                ];
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
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
                'data' => [
                    'errors' => [
                        'token' => 'Token yalnışdır və ya artıq aktiv deyil'
                    ]
                ]
            ];
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
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
