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
    'status',
    'username'
  ];

  public function getShop(){
    return $this->belongsTo('App\Shop','shop_id');
  }

  public function get_report_status(){
    return $this->belongsTo('App\SocialReportStatus','report_status');
  }

  public function get_report_replies(){
    return $this->belongsTo('App\SocialReportReply','reply_description');
  }

  public function get_report_cancels(){
    return $this->belongsTo('App\SocialReportCancel','cancel_description');
  }



}
