<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteTrackLog extends Model
{
  protected $fillable = ['route','user_ip'];
}
