<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

  public function checkRole($role_id){
    return PermissionRole::where('permission_id',$this->id)->where('role_id',$role_id)->count();
  }

}
