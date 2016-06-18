<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Home
Route::get('/', 'IndexController@index');

// Settings
Route::get('/settings', 'UserController@settings');

// API calls
Route::controller('api', 'ApiController');

// HTML renders
Route::controller('html', 'HtmlController');