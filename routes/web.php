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
Route::get('login' , 'Authenticate\LoginController@index')->name('admin.login');

Route::post('login/submit' , 'Authenticate\LoginController@login')->name('admin.login.submit');
