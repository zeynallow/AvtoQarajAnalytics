<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneSignal extends Model
{
    protected $table = 'onesignal';

    protected $fillable = [
        'user_id',
        'player_id'
    ];

    public function user(){
        $this->belongsTo(User::class, 'user_id');
    }
}
