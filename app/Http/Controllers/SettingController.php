<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermissionRole;
use App\Permission;
use App\Role;
use Route;

class SettingController extends Controller
{

  public function index(){
    return view('app.settings.index');
  }

  public function updatePermissions(){
    $permission_ids = [];

    foreach (Route::getRoutes()->getRoutes() as $key => $route){
      $action = $route->getActionname();
      $_action = explode('@',$action);

      $controller = $_action[0];
      $method = end($_action);

      $permission_check = Permission::where(
        ['controller'=>$controller,'method'=>$method]
        )->first();

        if(!$permission_check){
          $permission = new Permission;
          $permission->controller = $controller;
          $permission->method = $method;
          $permission->save();
          $permission_ids[] = $permission->id;
        }
      }
      // find admin roles
      $admin_role = Role::where('role_name','admin')->first();
      // add new permission admin
      $admin_role->role_permissions()->attach($permission_ids);

      return redirect()->back();
    }


    public function roles(){
      $roles = Role::all();
      return view('app.settings.roles',compact('roles'));
    }

    public function roles_permissions($role_id){
      $permissions = Permission::all();
      $role_permissions = PermissionRole::where('role_id',$role_id)->get();
      return view('app.settings.role_permissions',compact('permissions','role_permissions','role_id'));
    }

    public function roles_permissions_update(Request $request,$role_id){

      if(empty($request->permission_id)){
        return redirect()->back();
      }

      $role = Role::where('id',$role_id)->first();
      $role->role_permissions()->sync($request->permission_id);

      return redirect()->back();
    }


  }
