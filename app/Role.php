<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

  public function role_permissions(){
    return $this->belongsToMany('App\PermissionRole','permission_roles','role_id','permission_id');
  }

  public function permissions(){
    return $this->hasMany('App\PermissionRole','role_id');
  }

}
