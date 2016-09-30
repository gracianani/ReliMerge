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

Route::post('/heatsource', 'HeatSourceController@showBasic');

Route::post('/heatsource/recents', 'HeatsourceController@showRealtime');

Route::post('/heatsource/stat', 'HeatsourceController@showStatByHeatSource');

Route::post('/heatsource/{id}/update', 'HeatsourceController@update');

Route::post('/heatsource/batchupdate', 'HeatsourceController@batchUpdate');

Route::post('/totalnet/stat', 'TotalNetController@showStatByTotalNet');

Route::post('/heatsource/recents/{id}/{parameter}', 'HeatsourceController@showRealtimeByParameter');

Route::post('/station', 'StationController@showBasic');