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
Auth::routes();

Route::get('/', 'Controller@home')->name('home');

Route::get('socialite/{provider}/{region?}', 'Auth\LoginController@redirectToProvider')->name('loginsocial');
Route::get('callback/socialite/{provider}', 'Auth\LoginController@handleProviderCallback');

Route::get(config('fish.routes.user_root') . '/{user_id}', 'Controller@user')->name('myhome');

Route::post(config('fish.routes.user_root') . '/{user_id}', 'Controller@userPost')->name('myhome_post');
