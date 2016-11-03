<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\User;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});


Route::get('greeting', function () {
    return view('welcome', ['name' => 'Samantha']);
});

Route::get('profile', function () {
    // Only authenticated users may enter...
})->middleware('auth.basic');

Route::get('usr/{user_id}/pd/{password}', function($user_id, $password){
	$user = User::find($user_id);
	$user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

	return response()->json(array( "p" => "true" ));
});

Route::get('heatsource/index', 'HeatsourceController@show');

Route::get('heatsource/recents', 'HeatsourceController@showRealtime');

Route::get('fire', 'DashboardController@fireQueue');

Route::get('pusher', 'DashboardController@pusher');

