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

/*
|--------------------------------------------------------------------------
| Test routes
|--------------------------------------------------------------------------
*/
Route::get('email', function () {
	return new \App\Mail\NewAffiliateTokenMail(\App\Token::query()->inRandomOrder()->first());
});

/*
|--------------------------------------------------------------------------
| Open routes
|--------------------------------------------------------------------------
|
| Routes that do not require user to authenticate and are publicly available
|
*/

Route::get('/', 'HomeController@home')->name('home');
Route::get('faq', 'HomeController@faq')->name('faq');
Route::get('terms', 'HomeController@terms')->name('terms');
Route::get('a/{code}', 'UserController@affiliate')->name('affiliate');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
|
| Routes that handle user authentication
|
*/

Route::get('auth/redirect', 'AuthController@redirectToSteam')->name('auth.redirect');
Route::get('auth/handle', 'AuthController@handle')->name('auth.handle');
Route::get('auth/logout', 'AuthController@logout')->name('auth.logout');

/*
|--------------------------------------------------------------------------
| User settings
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
	Route::get('settings', 'UserSettingController@edit')->name('settings');
	Route::patch('settings', 'UserSettingController@update')->name('settings');
});

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
	Route::get('search', 'SearchController@search')->name('search');
});

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->group(function () {
	Route::get('products', 'ProductController@index')->name('products.index')->middleware('can:list,App\Product');
	Route::get('products/create', 'ProductController@create')->name('products.create')->middleware('can:store,App\Product');
	Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit')->middleware('can:update,product');

	Route::post('products', 'ProductController@store')->name('products.store')->middleware('can:store,App\Product');

	Route::patch('products/{product}', 'ProductController@update')->name('products.update')->middleware('can:update,product');

	Route::delete('products/{product}', 'ProductController@destroy')->name('products.destroy')->middleware('can:destroy,product');
});

/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/

Route::middleware(['terms'])->group(function () {
	Route::get('orders', 'OrderController@index')->name('orders.index')->middleware('can:list,App\Order');
	Route::get('orders/create/{product}', 'OrderController@create')->name('orders.create')->middleware('can:store,App\Order');
	Route::get('orders/{order}', 'OrderController@show')->name('orders.show')->middleware('can:view,order');
	Route::get('orders/{order}/edit', 'OrderController@edit')->name('orders.edit')->middleware('can:update,order');
	Route::get('orders/{order}/gift', 'OrderController@gift')->name('orders.gift')->middleware('can:transfer,order');

	Route::post('orders/{product}', 'OrderController@store')->name('orders.store')->middleware('can:store,App\Order');

	Route::patch('orders/{order}/activate', 'OrderController@activate')->name('orders.activate')->middleware('can:activate,order');
	Route::patch('orders/{order}/transfer', 'OrderController@transfer')->name('orders.transfer')->middleware('can:transfer,order');
	Route::patch('orders/{order}', 'OrderController@update')->name('orders.update')->middleware('can:update,order');
});

/*
|--------------------------------------------------------------------------
| Affiliates
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'terms'])->group(function () {
	Route::get('affiliates', 'AffiliateController@index')->name('affiliates.index');
});

/*
|--------------------------------------------------------------------------
| SourceMod admins
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->group(function () {
	Route::get('admins', 'AdminController@index')->name('admins.index')->middleware('can:list,App\Admin');
	Route::get('admins/create', 'AdminController@create')->name('admins.create')->middleware('can:store,App\Admin');
	Route::get('admins/{admin}/edit', 'AdminController@edit')->name('admins.edit')->middleware('can:update,admin');

	Route::post('admins', 'AdminController@store')->name('admins.store')->middleware('can:store,admin');

	Route::patch('admins/{admin}', 'AdminController@update')->name('admins.update')->middleware('can:update,admin');

	Route::delete('admins/{admin}', 'AdminController@destroy')->name('admins.destroy')->middleware('can:destroy,admin');
});

/*
|--------------------------------------------------------------------------
| Tokens
|--------------------------------------------------------------------------
*/

Route::middleware(['terms', 'auth'])->group(function () {
	Route::get('tokens', 'TokenController@index')->name('tokens.index')->middleware('can:list,App\Token');
	Route::get('tokens/create', 'TokenController@create')->name('tokens.create')->middleware('can:store,App\Token');
	Route::get('tokens/{token}', 'TokenController@show')->name('tokens.show')->middleware('can:view,token');

	Route::post('tokens/{token}', 'TokenController@use')->name('tokens.use')->middleware('can:use,token');
	Route::post('tokens', 'TokenController@store')->name('tokens.store')->middleware('can:store,App\Token');
});

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->group(function () {
	Route::get('users', 'UserController@index')->name('users.index')->middleware('can:list,App\User');

	Route::patch('users/{user}/admin', 'UserController@admin')->name('users.admin')->middleware('can:admin,user');
});