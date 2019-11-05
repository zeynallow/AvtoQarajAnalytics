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

Auth::routes();


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

});
