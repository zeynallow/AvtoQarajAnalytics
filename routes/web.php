<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'HomeController@index')->name('home');
  Route::get('/home', 'HomeController@index');
  Route::get('/test', 'HomeController@test');


  Route::get('/products', 'ProductController@index')->name('products.index');
  Route::get('/categories', 'CategoryController@index')->name('categories.index');
  Route::get('/car_searches', 'CarSearchController@index')->name('car_searches.index');
  Route::get('/route_tracks', 'RouteTrackController@index')->name('route_tracks.index');
  Route::get('/shops', 'ShopController@index')->name('shops.index');
  Route::get('/shops/categories', 'ShopController@categories')->name('shops.categories');

  Route::get('/users', 'UserController@index')->name('users.index');
  Route::get('/users/edit/{user_id}', 'UserController@edit')->name('users.edit');
  Route::post('/users/edit/{user_id}', 'UserController@update')->name('users.update');
  Route::get('/users/create', 'UserController@create')->name('users.create');
  Route::post('/users/store', 'UserController@store')->name('users.store');

});
