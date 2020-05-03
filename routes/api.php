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
Route::get('/random/', 'PlaceholderController@api')->defaults('task', 'random');

# Random with size
Route::get('/random/{size}/', 'PlaceholderController@api')->defaults('task', 'randomWithSize');
