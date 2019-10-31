<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTrack extends Model
{
    protected $fillable = ['category_id','date','click_count','click_count_unique'];

}
