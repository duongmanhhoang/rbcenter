<?php

Route::get('/', function () {
    return view('admin.index');
})->name('admin.index');

Route::prefix('users')->name('admin.users.')->group(function () {
    $c = 'Admin\UserController@';
    Route::get('/', $c . 'index')->name('index');
    Route::get('create', $c . 'create')->name('create');
    Route::get('/edit/{id}', $c . 'edit')->name('edit');
    Route::post('store', $c . 'store')->name('store');
    Route::post('/update/{id}', $c . 'update')->name('update');
    Route::get('/disable/{id}', $c . 'disable')->name('disable');
    Route::get('/ban/{id}', $c . 'ban')->name('ban');
    Route::get('/restore/{id}', $c . 'restore')->name('restore');
});

