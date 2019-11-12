<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class RolesAuth
{
  /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */
  public function handle($request, Closure $next)
  {
    $role = Role::findOrFail(auth()->user()->role_id);
    $permissions = $role->permissions;

    $actionName = class_basename($request->route()->getActionname());

    foreach ($permissions as $permission){

      $_namespaces_chunks = explode('\\', $permission->permission->controller);
      $controller = end($_namespaces_chunks);
      if ($actionName == $controller . '@' . $permission->permission->method){
        return $next($request);
      }
    }

    return abort(403);
  }
  
}
