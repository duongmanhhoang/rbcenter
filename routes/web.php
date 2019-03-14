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
Route::get('logout' , 'Authenticate\LoginController@logout')->name('admin.logout');
Route::get('put', function() {
    Storage::cloud()->put('test.txt', 'Hello World');
    return 'File was saved to Google Drive';
});

Route::get('test',function (){
    return view('test');
});

Route::post('upload' , function (\Illuminate\Http\Request $request){
    $filePath = $request->image->path();
    $fileData = File::get($filePath);
    $fileName = uniqid().'-'.$request->image->getClientOriginalName();
    Storage::cloud()->put($fileName , $fileData);
    $fileUrl = Storage::cloud()->url($fileName);
    dd($fileUrl);
});
