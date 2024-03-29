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

Route::get('/auth/{channel}', 'Auth\LoginController@redirectToProvider');

# Google
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
# Twitter
Route::get('auth/twitter/callback', 'Auth\LoginController@handleTwitterCallback');
# Github
Route::get('auth/github/callback', 'Auth\LoginController@handleGithubCallback');
# Facebook
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');

Route::get('/location/{panoId}/status/', 'LocationController@hasLikedLocation');
Route::get('/location/favourite/{locationName}/{latitude}/{longitude}/{panoId}/{panoHeading}/{panoPitch}/{panoZoom}', 'LocationController@storeFavourite');
Route::delete('/location/{panoId}/unfavourite/', 'LocationController@deleteFavourite');
Route::post('/favourite/details', 'LocationController@favouriteDetails');
# Pioneer
Route::get('/get/{panoId}/pioneer', 'LocationController@pioneer');
# Streetview Details
Route::get('/get/{eyeshotId}/details', 'LocationController@eyeshot');
Route::post('/get/random', 'LocationController@random');
# Newsletter Sub
Route::post('/newsletter', 'NewsletterController@add');

#Pages
Route::get('/', 'PagesController@welcome');
Route::get('/home', 'PagesController@welcome');
Route::get('/feed', 'PagesController@feed');
Route::get('/recent', 'PagesController@feed');
Route::get('/popular', 'PagesController@popular');
Route::get('/search', 'PagesController@search');
Route::get('/categories', 'PagesController@categories');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/{username}/shot/{id}', 'PagesController@show');
Route::post('/share', 'PagesController@sharer');
Route::get('/get/share/{sharer}', 'PagesController@getSharer');
Route::get('/placeholder', 'PagesController@placeholder');
Route::get('/placeholders', 'PagesController@placeholder');

Route::get('/logout', 'Auth\LoginController@logout');

#Profile
Route::get('/{username}', 'ProfileController@index');