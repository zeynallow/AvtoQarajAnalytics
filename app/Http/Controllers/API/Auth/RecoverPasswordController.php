<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\SendMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class RecoverPasswordController extends Controller
{
    public function sendOtp(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $sent = Event::dispatch(new SendMail(
            $request->email,
            'Şifrə bərpa kodu',
           'AB5413',
            'app.emails.otp'
        ));

        return response()->json([
            'message' => 'success',
            'data' => $sent
        ]);
    }
}
