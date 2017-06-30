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
Route::get('/home/article', ['as'=>'home/article','uses'=>'Home\ArticleController@index']);
Route::get('/home/article/index', ['as'=>'home/article/index','uses'=>'Home\ArticleController@index']);
Route::get('/home/article/lists', ['as'=>'home/article/lists','uses'=>'Home\ArticleController@lists']);
Route::get('/home/article/detail', ['as'=>'home/article/detail','uses'=>'Home\ArticleController@detail']);
Route::get('/home/page/index', ['as'=>'home/page/index','uses'=>'Home\PageController@index']);
Route::get('/home/base/getFile', ['as'=>'home/base/getFile','uses'=>'Home\BaseController@getFile']);
Route::get('/home/search/index', ['as'=>'home/search/index','uses'=>'Home\SearchController@index']);

Auth::routes();

Route::get('/home', 'Home\UserController@index');