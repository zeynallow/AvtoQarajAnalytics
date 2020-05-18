<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
  protected $connection = 'mysql_primary';

  public static function getShopName($shop_id){
    $get = Shop::select('name')->where('id',$shop_id)->first();
    return ($get) ? $get->name : '';
  }

}
