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

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', function () {
    return "hello";
});

Route::get('socialite/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('socialite/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
