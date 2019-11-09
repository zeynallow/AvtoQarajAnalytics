<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialReport extends Model
{

  protected $fillable = [
    'network_type',
    'product_id',
    'shop_id',
    'product_name',
    'client_name',
    'client_contact',
    'client_comment',
    'client_auto_car',
    'client_auto_year',
    'client_auto_vin',
    'partner_comment',
    'report_status',
    'status'
  ];

  public function getShop(){
    return $this->belongsTo('App\Shop','shop_id');
  }

}
