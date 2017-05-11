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
Route::get('/home/index/index', ['as'=>'home/index/index','uses'=>'Home\IndexController@index']);
Route::get('/home/index/lists', ['as'=>'home/index/lists','uses'=>'Home\IndexController@lists']);
Route::get('/home/index/detail', ['as'=>'home/index/detail','uses'=>'Home\IndexController@detail']);
Auth::routes();

Route::get('/home', 'Home\UserController@index');