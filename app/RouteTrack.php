<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteTrack extends Model
{
  protected $fillable = ['route','date','click_count','click_count_unique'];

}
