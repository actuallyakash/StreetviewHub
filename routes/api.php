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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Random
Route::get('/', 'PlaceholderController@api');

# Sized
Route::get('/{size}/', 'PlaceholderController@api');

# Random with size
Route::get('/random/{size}/', 'PlaceholderController@api');
Route::get('/{size}/random/', 'PlaceholderController@api');