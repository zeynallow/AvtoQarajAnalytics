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
//RolesAuth
Route::group(['middleware' => ['auth','RolesAuth']], function () {
  Route::get('/', 'HomeController@index')->name('home');
  Route::get('/home', 'HomeController@index');
  Route::get('/test', 'HomeController@test');


  Route::get('/products', 'ProductController@index')->name('products.index');
  Route::get('/categories', 'CategoryController@index')->name('categories.index');
  Route::get('/car_searches', 'CarSearchController@index')->name('car_searches.index');
  Route::get('/route_tracks', 'RouteTrackController@index')->name('route_tracks.index');
  Route::get('/shops', 'ShopController@index')->name('shops.index');
  Route::get('/shops/categories', 'ShopController@categories')->name('shops.categories');

  Route::get('/social_reports', 'SocialReportController@index')->name('social_reports.index');
  Route::get('/social_reports/create', 'SocialReportController@create')->name('social_reports.create');
  Route::post('/social_reports/store', 'SocialReportController@store')->name('social_reports.store');
  Route::get('/social_reports/reports', 'SocialReportController@reports')->name('social_reports.reports');

  Route::get('/social_reports/cancelRequest/{request_id}/{desc}', 'SocialReportController@cancelRequest')->name('social_reports.cancelRequest');
  Route::get('/social_reports/confirmRequest/{request_id}/{desc}', 'SocialReportController@confirmRequest')->name('social_reports.confirmRequest');

  Route::get('/social_reports/changeCancelRequest/{request_id}/{desc}', 'SocialReportController@changeCancelRequest')->name('social_reports.changeCancelRequest');
  Route::get('/social_reports/changeConfirmRequest/{request_id}/{desc}', 'SocialReportController@changeConfirmRequest')->name('social_reports.changeConfirmRequest');

  Route::get('/social_reports/softDeleteRequest/{request_id}', 'SocialReportController@softDeleteRequest')->name('social_reports.softDeleteRequest');
  Route::post('/social_reports/update/{request_id}', 'SocialReportController@update')->name('social_reports.update');
  Route::get('/social_reports/getProductInfo/{product_id}', 'SocialReportController@getProductInfo')->name('social_reports.getProductInfo');




  Route::get('/users', 'UserController@index')->name('users.index');
  Route::get('/users/edit/{user_id}', 'UserController@edit')->name('users.edit');
  Route::post('/users/edit/{user_id}', 'UserController@update')->name('users.update');
  Route::get('/users/create', 'UserController@create')->name('users.create');
  Route::post('/users/store', 'UserController@store')->name('users.store');
  Route::get('/users/shop_cars', 'UserController@shop_cars_index')->name('users.shop_cars_index');
  Route::get('/users/shop_cars/create', 'UserController@shop_cars_create')->name('users.shop_cars_create');
  Route::post('/users/shop_cars/store', 'UserController@shop_cars_store')->name('users.shop_cars_store');
  Route::get('/users/shop_cars/delete/{id}', 'UserController@shop_cars_delete')->name('users.shop_cars_delete');

  Route::get('/settings', 'SettingController@index')->name('settings.index');
  Route::get('/settings/updatePermissions', 'SettingController@updatePermissions')->name('settings.updatePermissions');
  Route::get('/settings/roles', 'SettingController@roles')->name('settings.roles');
  Route::get('/settings/roles/{role_id}/permissions', 'SettingController@roles_permissions')->name('settings.roles.permissions');
  Route::post('/settings/roles/{role_id}/permissions', 'SettingController@roles_permissions_update')->name('settings.roles.permissions.update');

});
