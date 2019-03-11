<?php

Route::get('/' , function (){
    return view('admin.index');
})->name('admin.index');

