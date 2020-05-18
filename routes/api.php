<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'cors'], function () {
  Route::post('/categoryTrack/category', 'API\CategoryTrackController@categoryTrack');
  Route::post('/routeTrack/route', 'API\RouteTrackController@routeTrack');
  Route::post('/productTrack/product', 'API\ProductTrackController@productTrack');
  Route::post('/carSearchTrack/car_search', 'API\CarSearchTrackController@carSearchTrack');
  Route::post('/shopTrack/shop', 'API\ShopTrackController@shopTrack');
  Route::post('/shopTrack/shop_category', 'API\ShopTrackController@shopCategoryTrack');

  Route::get('/cardata/getMake/{car_type_id}', 'API\CarDataController@getMake');

});
