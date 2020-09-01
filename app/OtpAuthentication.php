<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtpAuthentication extends Model
{
    const EXPIRED = 1;
    const ACTIVE = 0;

    protected $table = 'otp_authentication';

    protected $fillable = [
        'otp',
        'email',
        'token',
        'expired',
    ];
}
