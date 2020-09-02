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

    Route::prefix('v1')->namespace('API')->group(function(){
        Route::namespace('Auth')->group(function (){
            Route::post('login', 'AuthController@login');
            Route::get('logout', 'AuthController@logout');
            Route::get('refresh', 'AuthController@refresh');
            Route::get('me', 'AuthController@me');

            Route::post('sendOtp', 'RecoverPasswordController@sendOtp')->name('sendOtp');
            Route::post('recoverPassword', 'RecoverPasswordController@recoverPassword')->name('recoverPassword');
        });

        Route::get('shops/{shopId}/reports', 'ShopReportController@index');
        Route::get('shops/{shopId}/reports/{report}', 'ShopReportController@getReport');

        Route::get('sendAcceptMessages', 'ShopReportController@sendAcceptMessages');
        Route::get('sendCancelMessages', 'ShopReportController@sendCancelMessages');
        Route::put('changeReportStatus/{report}', 'ShopReportController@changeReportStatus');
    });

});
