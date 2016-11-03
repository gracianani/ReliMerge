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
    return response()->json( array('u' => $request->user()->userId ) );
})->middleware('auth:api');

Route::get('/refresh', function( Request $request) {
	$http = new GuzzleHttp\Client;

	$response = $http->post('http://your-app.com/oauth/token', [
	    'form_params' => [
	        'grant_type' => 'refresh_token',
	        'refresh_token' => 'the-refresh-token',
	        'client_id' => 'client-id',
	        'client_secret' => 'client-secret',
	        'scope' => '',
	    ],
	]);

	return json_decode((string) $response->getBody(), true);

});

Route::post('/blocks', 'DashboardController@show')->middleware('auth:api');

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

Route::post('/station/{station_id}/subline/{subline_id}', 'StationController@updateControlParameters')->middleware('\App\Http\Middleware\Cors');

Route::post('/station/{station_id}/subline/{subline_id}/hourly/{parameter}', 'StationController@getRealtimeParameters')->middleware('\App\Http\Middleware\Cors');

Route::post('/stationfilter', 'StationController@filter')->middleware('\App\Http\Middleware\Cors');

Route::post('/settings/blocks/{block_name}/headers/update' , 'HomeController@saveSettings')
	->middleware('\App\Http\Middleware\Cors')->middleware('auth:api');

