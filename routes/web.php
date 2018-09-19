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

Route::get('/', 'Controller@user')->name('home');

Route::get('hello', function () {
    return "hello";
});

Route::get('socialite/{provider}', 'Auth\LoginController@redirectToProvider')->name('loginsocial');
Route::get('socialite/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get(config('fish.routes.user_root') . '/{user_id}', 'Controller@user')->name('myhome');
