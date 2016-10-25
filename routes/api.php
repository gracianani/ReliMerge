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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::post('/blocks', 'DashboardController@show');

Route::post('/heatsource', 'HeatSourceController@showBasic')->middleware('\App\Http\Middleware\Cors');

Route::post('/heatsource/recents', 'HeatsourceController@showRealtime')->middleware('\App\Http\Middleware\Cors');

Route::post('/heatsource/stat', 'HeatsourceController@showStatByHeatSource')->middleware('\App\Http\Middleware\Cors');

Route::post('/heatsource/{id}/update', 'HeatsourceController@update')->middleware('\App\Http\Middleware\Cors');

Route::post('/heatsource/batchupdate', 'HeatsourceController@batchUpdate')->middleware('\App\Http\Middleware\Cors');

Route::post('/totalnet/stat', 'TotalNetController@showStatByTotalNet')->middleware('\App\Http\Middleware\Cors');

Route::post('/heatsource/recents/{id}/{parameter}', 'HeatsourceController@showRealtimeByParameter')->middleware('\App\Http\Middleware\Cors');

Route::post('/station', 'StationController@showBasic')->middleware('\App\Http\Middleware\Cors');

Route::post('/station/recents', 'StationController@showRealtime')->middleware('\App\Http\Middleware\Cors');

Route::post('/station/{id}/blocks', 'DashboardController@showStationInfo')->middleware('\App\Http\Middleware\Cors');
