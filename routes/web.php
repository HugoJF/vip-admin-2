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

Route::get('email', function () {
	return new \App\Mail\OrderCreated(\App\Order::find('d8243'));
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

Route::middleware(['admin'])->group(function () {
	Route::get('products', 'ProductController@index')->name('products.index');
	Route::get('products/create', 'ProductController@create')->name('products.create');
	Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit');

	Route::post('products', 'ProductController@store')->name('products.store');

	Route::patch('products/{product}', 'ProductController@update')->name('products.update');

	Route::delete('products/{product}', 'ProductController@destroy')->name('products.destroy');
});

Route::middleware(['terms'])->group(function () {
	Route::get('orders', 'OrderController@index')->name('orders.index');
	Route::get('orders/create/{product}', 'OrderController@create')->name('orders.create')->where('duration', '[0-9]+');
	Route::get('orders/{order}', 'OrderController@show')->name('orders.show');
	Route::get('orders/{order}/edit', 'OrderController@edit')->name('orders.edit');
	Route::get('orders/{order}/gift', 'OrderController@gift')->name('orders.gift');

	Route::post('orders/{product}', 'OrderController@store')->name('orders.store');

	Route::patch('orders/{order}/activate', 'OrderController@activate')->name('orders.activate');
	Route::patch('orders/{order}/transfer', 'OrderController@transfer')->name('orders.transfer');
	Route::patch('orders/{order}', 'OrderController@update')->name('orders.update');
});

Route::middleware(['auth', 'terms'])->group(function () {
	Route::get('affiliates', 'AffiliateController@index')->name('affiliates.index');
});

Route::middleware(['admin'])->group(function () {
	Route::get('admins', 'AdminController@index')->name('admins.index');
	Route::get('admins/create', 'AdminController@create')->name('admins.create');
	Route::get('admins/{admin}/edit', 'AdminController@edit')->name('admins.edit');

	Route::post('admins', 'AdminController@store')->name('admins.store');

	Route::patch('admins/{admin}', 'AdminController@update')->name('admins.update');

	Route::delete('admins/{admin}', 'AdminController@destroy')->name('admins.destroy');
});

Route::middleware(['terms', 'auth'])->group(function () {
	Route::get('tokens', 'TokenController@index')->name('tokens.index');
	Route::get('tokens/create', 'TokenController@create')->name('tokens.create');
	Route::get('tokens/{token}', 'TokenController@show')->name('tokens.show');

	Route::post('tokens/{token}', 'TokenController@use')->name('tokens.use');
	Route::post('tokens', 'TokenController@store')->name('tokens.store');
});

Route::middleware(['admin'])->group(function () {
	Route::get('users', 'UserController@index')->name('users.index');
});
