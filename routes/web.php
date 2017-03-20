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

Route::get('/', 'Home\IndexController@index');
Route::get('/home/index/lists', 'Home\IndexController@lists');
Route::get('/home/index/detail', 'Home\IndexController@detail');
Auth::routes();

Route::get('/home', 'Home\UserController@index');