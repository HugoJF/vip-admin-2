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

Route::get('template', function () {
	return view('welcome');
});
Route::get('billing', function () {
	return view('billing');
});
Route::get('vip', function () {
	return view('vip.vip');
});

Route::get('search1', function () {
	return \App\Token::search('Mr. Lavern Kemmer II	')->get();
});

Route::get('{all?}', function () {
	return view('welcome');
})->where('all', '([A-z\d\-\/_.]+)?');