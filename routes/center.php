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

Auth::routes();

// Center登录默认路由
Route::get('center/login', 'Auth\CenterLoginController@login');
Route::post('center/login', 'Auth\CenterLoginController@login');
Route::post('center/register', 'Auth\CenterRegisterController@register');

// Center退出
Route::get('center/logout', 'Auth\CenterLoginController@logout');
// 用户锁屏
Route::get('center/lock', 'Auth\CenterLockController@lock');
// 用户解锁
Route::post('center/unlock', 'Auth\CenterLockController@unlock');
// 用户锁屏状态
Route::get('center/lockStatus', 'Auth\CenterLockController@lockStatus');

// Center路由组
Route::group(['prefix' => 'center','middleware' => ['web','auth:center'],'namespace' => 'Center'], function()
{
    Route::get('index/', 'IndexController@index');
    Route::get('index/index', 'IndexController@index');
    Route::get('user/getUserInfo', 'UserController@getUserInfo');
    Route::post('user/changePassword', 'UserController@changePassword');
    Route::get('finder/index', 'FinderController@index');
    Route::get('finder/sidebar', 'FinderController@sidebar');
    Route::get('finder/openPath', 'FinderController@openPath');
    Route::get('finder/deletePath', 'FinderController@deletePath');
    Route::get('finder/renamePath', 'FinderController@renamePath');
    Route::get('finder/makeDir', 'FinderController@makeDir');
    Route::get('finder/makeFile', 'FinderController@makeFile');
    Route::get('finder/emptyTrash', 'FinderController@emptyTrash');
    Route::get('finder/movePath', 'FinderController@movePath');
    Route::get('finder/copyPath', 'FinderController@copyPath');
    Route::get('editor/openFile', 'EditorController@openFile');
    Route::post('editor/saveFile', 'EditorController@saveFile');
    Route::post('finder/uploadFile', 'FinderController@uploadFile');
    Route::get('finder/callbackMovePath', 'FinderController@callbackMovePath');
    Route::get('finder/downloadFile', 'FinderController@downloadFile');
    Route::get('dock/getLists', 'DockController@getLists');
    Route::get('wallpaper/getInfo', 'WallpaperController@getInfo');
    Route::get('wallpaper/getLists', 'WallpaperController@getLists');
    Route::get('wallpaper/setting', 'WallpaperController@setting');
    Route::get('appstore/getInfo', 'AppstoreController@getInfo');
    Route::get('appstore/getLists', 'AppstoreController@getLists');
    Route::get('appstore/addToDesktop', 'AppstoreController@addToDesktop');
    Route::get('appstore/addToDock', 'AppstoreController@addToDock');
});
Route::get('center/finder/openFileWithBrowser', 'Center\FinderController@openFileWithBrowser');