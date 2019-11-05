<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Shop;
use App\Role;
use App\CarType;
use App\ShopUserCar;
use App\ShopUser;

class UserController extends Controller
{

  public function __construct(){
    $this->middleware('adminOnly');
  }

  /*
  * Users
  */
  public function index(){
    $users = User::paginate(10);
    return view('app.users.index',compact('users'));
  }

  /*
  * Edit User
  */
  public function edit($user_id){
    $user = User::where('id',$user_id)->firstOrFail();
    $shops = Shop::all();
    $roles = Role::all();

    return view('app.users.edit',compact('user','shops','roles'));
  }

  /*
  * Update User
  */
  public function update(Request $request,$user_id){

    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|unique:users,email,'.$user_id,
      'role_id' => 'required'
    ]);

    $change_password = [];

    if($request->password != NULL){
      $change_password = ['password'=>Hash::make($request->password)];
    }

    $update = User::where('id',$user_id)
    ->update(array_merge([
      'name'=>$request->name,
      'email'=>$request->email,
      'role_id'=>$request->role_id,
      'shop_id'=>$request->shop_id
    ],$change_password));


    return redirect()->back();

  }

  /*
  * Create User
  */
  public function create(){
    $shops = Shop::all();
    $roles = Role::all();
    return view('app.users.create',compact('shops','roles'));
  }

  /*
  * Store User
  */
  public function store(Request $request){

    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8',
      'role_id' => 'required'
    ]);

    $store = User::create([
      'name'=>$request->name,
      'email'=>$request->email,
      'password'=>Hash::make($request->password),
      'role_id'=>$request->role_id,
      'shop_id'=>$request->shop_id
    ]);

    return redirect()->route('users.index');

  }

  /*
  * shop_cars_index
  */
  public function shop_cars_index(){
    $shop_user_cars = ShopUserCar::paginate(10);
    return view('app.users.shop_cars',compact('shop_user_cars'));
  }

  /*
  * shop_cars_create
  */
  public function shop_cars_create(){
    $shops = Shop::all();
    $car_types = CarType::all();
    return view('app.users.shop_cars_create',compact('shops','car_types'));
  }

  /*
  * shop_cars_store
  */
  public function shop_cars_store(Request $request){

    $request->validate([
      'shop_id' => 'required',
      'id_car_type' => 'required',
      'id_car_make' => 'required',
    ]);

    $store = ShopUserCar::create([
      'shop_id'=>$request->shop_id,
      'id_car_type'=>$request->id_car_type,
      'id_car_make'=>$request->id_car_make
    ]);

    return redirect()->route('users.shop_cars_index');

  }

  /*
  * shop_cars_store
  */
  public function shop_cars_delete($id){

    $delete = ShopUserCar::where('id',$id)->delete();

    return redirect()->back();
  }








}
