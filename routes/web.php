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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/auth/{channel}', 'Auth\LoginController@redirectToProvider');

# Google
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
# Twitter
Route::get('auth/twitter/callback', 'Auth\LoginController@handleTwitterCallback');
# Github
Route::get('auth/github/callback', 'Auth\LoginController@handleGithubCallback');

Route::get('/location/{panoId}/status/', 'LocationController@hasLikedLocation');
Route::get('/location/favourite/{locationName}/{latitude}/{longitude}/{panoId}/{panoHeading}/{panoPitch}/{panoZoom}', 'LocationController@storeFavourite');
Route::delete('/location/{panoId}/unfavourite/', 'LocationController@deleteFavourite');
Route::post('/favourite/details', 'LocationController@favouriteDetails');
# Pioneer
Route::get('/get/{panoId}/pioneer', 'LocationController@pioneer');
# Eyeshot Details
Route::get('/get/{eyeshotId}/details', 'LocationController@eyeshot');

#Pages
Route::get('/feed', 'PagesController@feed');



Route::get('/logout', 'Auth\LoginController@logout');

#Profile
Route::get('/{username}', 'ProfileController@index');