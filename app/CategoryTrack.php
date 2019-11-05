<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTrack extends Model
{
  protected $fillable = ['category_id','date','click_count','click_count_unique'];

  protected $with = ['category'];

  public function category(){
    return $this->belongsTo('App\Category','category_id');
  }
}
