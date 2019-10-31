<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTrackLog extends Model
{
    protected $fillable = ['category_id','user_ip'];
}
