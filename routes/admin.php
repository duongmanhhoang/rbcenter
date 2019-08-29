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
    Route::get('data' , $c .'dataTable')->name('data');
});

Route::prefix('classes')->name('admin.classes.')->group(function () {
    $c = 'Admin\ClassController@';
    Route::get('/', $c . 'index')->name('index');
    Route::get('create', $c . 'create')->name('create');
    Route::get('/{id}/student-list', $c . 'studentList')->name('studentList');
    Route::post('/{id}/add-student', $c . 'addStudent')->name('addStudent');
    Route::get('/delete-student/{id}/{student_code}', $c . 'deleteStudent')->name('deleteStudent');
    Route::post('/update-timetable', $c . 'updateTimetable')->name('updateTimetable');
    Route::post('/export/{id}', $c . 'export')->name('export');
    Route::get('/edit/{id}', $c . 'edit')->name('edit');
    Route::post('store', $c . 'store')->name('store');
    Route::post('/update/{id}', $c . 'update')->name('update');
    Route::get('/disable/{id}', $c . 'disable')->name('disable');
    Route::get('/ban/{id}', $c . 'ban')->name('ban');
    Route::get('/restore/{id}', $c . 'restore')->name('restore');

});

Route::prefix('products')->name('admin.products.')->group(function () {
    $c = 'Admin\ProductController@';
    Route::get('/', $c . 'index')->name('index');
    Route::get('/create', $c . 'create')->name('create');
    Route::post('/store', $c . 'store')->name('store');
    Route::post('/upload-video' , $c . 'uploadVideo')->name('video.upload');
    Route::post('delete-video' , $c . 'deleteVideo')->name('video.delete');
    Route::get('edit/{id}', $c . 'edit')->name('edit');
    Route::post('update/{id}', $c . 'update')->name('update');
    Route::get('/disable/{id}', $c . 'disable')->name('disable');
    Route::get('/restore/{id}', $c . 'restore')->name('restore');

    //categories
    $c = 'Admin\ProductCategoryController@';
    Route::get('/categories', $c . 'index')->name('categories.index');
    Route::get('/categories/create', $c . 'create')->name('categories.create');
    Route::post('/categories/store', $c . 'store')->name('categories.store');
    Route::get('/categories/edit/{id}', $c . 'edit')->name('categories.edit');
    Route::post('/categories/update/{id}', $c . 'update')->name('categories.update');
    Route::get('/categories/disable/{id}', $c . 'disable')->name('categories.disable');
    Route::get('/categories/restore/{id}', $c . 'restore')->name('categories.restore');

});



Route::prefix('posts')->name('admin.posts.')->group(function () {
    $c = 'Admin\PostController@';
    Route::get('/', $c . 'index')->name('index');
    Route::get('/create', $c . 'create')->name('create');
    Route::post('/store', $c . 'store')->name('store');
    Route::post('/upload-video' , $c . 'uploadVideo')->name('video.upload');
    Route::post('delete-video' , $c . 'deleteVideo')->name('video.delete');
    Route::get('edit/{id}', $c . 'edit')->name('edit');
    Route::post('update/{id}', $c . 'update')->name('update');
    Route::get('/disable/{id}', $c . 'disable')->name('disable');
    Route::get('/restore/{id}', $c . 'restore')->name('restore');

    //categories
    $c = 'Admin\PostCategoryController@';
    Route::get('/categories', $c . 'index')->name('categories.index');
    Route::get('/categories/create', $c . 'create')->name('categories.create');
    Route::post('/categories/store', $c . 'store')->name('categories.store');
    Route::get('/categories/edit/{id}', $c . 'edit')->name('categories.edit');
    Route::post('/categories/update/{id}', $c . 'update')->name('categories.update');
    Route::get('/categories/disable/{id}', $c . 'disable')->name('categories.disable');
    Route::get('/categories/restore/{id}', $c . 'restore')->name('categories.restore');

});



