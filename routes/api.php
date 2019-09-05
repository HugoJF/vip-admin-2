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

//Route::prefix('v1')->group(function () {
//
//	Route::prefix('search')->name('search.')->group(function () {
//		Route::get('/', 'SearchController@search')->name('search');
//	});
//
//	Route::prefix('auth')->name('auth.')->group(function () {
//		Route::get('/', 'AuthController@index')->name('index');
//		Route::post('refresh', 'AuthController@refresh')->middleware('jwt.refresh')->name('refresh');
//		Route::post('/', 'AuthController@store')->name('store');
//	});
//
//	Route::prefix('self')->name('users.')->group(function () {
//		Route::patch('settings', 'UserController@settings')->name('settings');
//	});
//
//	Route::prefix('users')->name('users.')->group(function () {
//		Route::get('{user}', 'UserController@show')->name('show')->middleware('can:view,user');
//		Route::patch('{user}/ban', 'UserController@ban')->name('show')->middleware('can:ban,user');
//	});
//
//	Route::prefix('admins')->name('admins.')->group(function () {
//		Route::get('/', 'AdminController@index')->name('index')->middleware('can:view,App\Admin');
//
//		Route::post('/', 'AdminController@store')->name('store')->middleware('can:store,App\Admin');
//
//		Route::patch('{admin}', 'AdminController@update')->name('update')->middleware('can:update,admin');
//
//		Route::delete('{admin}', 'AdminController@destroy')->name('destroy')->middleware('can:destroy,admin');
//	});
//
//	Route::prefix('orders')->name('orders.')->group(function () {
//		Route::get('/', 'OrderController@index')->name('index')->middleware('can:list,App\Order');
//		Route::get('{order}', 'OrderController@show')->name('show')->middleware('can:view,order');
//		Route::post('/', 'OrderController@store')->name('store')->middleware('can:create,App\Order');
//		Route::patch('{order}/activate', 'OrderController@activate')->name('activate')->middleware('can:activate,order');
//		Route::patch('{order}', 'OrderController@update')->name('update')->middleware('can:update,order');
//	});
//
//	Route::prefix('settings')->name('settings.')->group(function () {
//		Route::get('/', 'SettingController@index')->name('index')->middleware('can:list,App\Setting');
//		Route::get('{setting}', 'SettingController@show')->name('show')->middleware('can:view,setting');
//		Route::patch('{setting}', 'SettingController@update')->name('update')->middleware('can:update,setting');
//		Route::delete('{setting}', 'SettingController@destroy')->name('destroy')->middleware('can:delete,setting');
//	});
//
//	Route::prefix('user-settings')->name('user-settings.')->group(function () {
//		Route::get('/', 'UserSettingController@index')->name('index')->middleware('can:list,App\UserSetting');
//		Route::post('/', 'UserSettingController@store')->name('store')->middleware('can:create,App\UserSetting');
//		Route::patch('{user_setting}', 'UserSettingController@updat')->name('update')->middleware('can:update,user_setting');
//	});
//
//	Route::prefix('tokens')->name('tokens.')->group(function () {
//		Route::get('/', 'TokenController@index')->name('index')->middleware('can:list,App\Token');
//		Route::post('/', 'TokenController@store')->name('store')->middleware('can:create,App\Token');
//		Route::post('use/{token}', 'TokenController@use')->name('use')->middleware('can:use,token');
//		Route::patch('{token}', 'TokenController@update')->name('update')->middleware('can:update,token');
//		Route::delete('{token}', 'TokenController@destroy')->name('destroy')->middleware('can:delete,token');
//	});
//});