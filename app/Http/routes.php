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

/** FRONT END **/
// Home
Route::get('/', 'IndexController@index');

// Settings
Route::get('/settings', 'UserController@settings');

// API calls
Route::controller('api', 'ApiController');

// HTML renders
Route::controller('html', 'HtmlController');

/** BACK END **/
// Users (index)
Route::get('/manager/users', 'Admin\UserController@index');

// Users
Route::controller('manager/users', 'Admin\UserController');

// Words (index)
Route::get('/manager/words', 'Admin\WordController@index');

// Words
Route::controller('manager/words', 'Admin\WordController');

// Lessons (index)
Route::get('/manager/lessons', 'Admin\LessonController@index');

// Lessons
Route::controller('manager/lessons', 'Admin\LessonController');

// Dashboard (index)
Route::get('/manager', 'Admin\IndexController@dashboard');

// Dashboard (fallback)
Route::controller('manager', 'Admin\IndexController');