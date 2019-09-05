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

Route::get('test', function () {
	$pendingOrders = \App\Order::query()->whereNull('synced_at')->where('paid', true)->where('canceled', false)->where('ends_at', '>', \Carbon\Carbon::now())->get();

	dd($pendingOrders->toArray());
});

Route::get('email', function () {
	return new \App\Mail\OrderActivated(\App\Order::first());
});

Route::get('/', 'HomeController@home')->name('home');
Route::get('faq', 'HomeController@faq')->name('faq');
Route::get('terms', 'HomeController@terms')->name('terms');
Route::get('a/{code}', 'UserController@affiliate')->name('affiliate');

Route::get('auth/redirect', 'AuthController@redirectToSteam')->name('auth.redirect');
Route::get('auth/handle', 'AuthController@handle')->name('auth.handle');
Route::get('auth/logout', 'AuthController@logout')->name('auth.logout');

Route::middleware(['auth'])->group(function () {
	Route::get('settings', 'UserSettingController@edit')->name('settings');
	Route::patch('settings', 'UserSettingController@update')->name('settings');
	Route::get('search', 'SearchController@search')->name('search');
});

Route::middleware(['terms'])->group(function () {
	Route::get('orders', 'OrderController@index')->name('orders.index');
	Route::get('orders/{duration}', 'OrderController@create')->name('orders.create')->where('duration', '[0-9]+');
	Route::get('orders/{order}', 'OrderController@show')->name('orders.show');
	Route::get('orders/{order}/edit', 'OrderController@edit')->name('orders.edit');
	Route::post('orders/{duration}', 'OrderController@store')->name('orders.store');
	Route::patch('orders/{order}/activate', 'OrderController@activate')->name('orders.activate');
	Route::patch('orders/{order}', 'OrderController@update')->name('orders.update');
});

Route::middleware(['terms'])->group(function () {
	Route::get('affiliates', 'AffiliateController@index')->name('affiliates.index');
});

Route::get('tokens', 'TokenController@index')->name('tokens.index');
Route::get('tokens/create', 'TokenController@create')->name('tokens.create');
Route::get('tokens/{token}', 'TokenController@show')->name('tokens.show');
Route::post('tokens/{token}', 'TokenController@use')->name('tokens.use');
Route::post('tokens', 'TokenController@store')->name('tokens.store');

Route::get('users', 'UserController@index')->name('users.index');