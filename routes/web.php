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

Route::get('/', function () {
    return view('welcome');
});


Route::get('greeting', function () {
    return view('welcome', ['name' => 'Samantha']);
});

Route::get('heatsource/index', 'HeatsourceController@show');

Route::get('heatsource/recents', 'HeatsourceController@showRealtime');

