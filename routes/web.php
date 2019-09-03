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
Route::get('login', 'Authenticate\LoginController@index')->name('admin.login');

Route::post('login/submit', 'Authenticate\LoginController@login')->name('admin.login.submit');
Route::get('logout', 'Authenticate\LoginController@logout')->name('admin.logout');
Route::get('put', function () {
    Storage::cloud()->put('test.txt', 'Hello World');
    return 'File was saved to Google Drive';
});

Route::get('test', function () {
    return view('test');
});

Route::get('picture'  , function (){
    dd(\Illuminate\Support\Facades\Cache::get('image_access_token'));
});

Route::post('upload', function (\Illuminate\Http\Request $request) {
    $api =new App\Api\Api();
    $imageName = uniqid().'-'.$request->image->getClientOriginalName();
    $image = base64_encode(file_get_contents($request->image->path()));
    $data = [
        'imageName' => $imageName,
        'image' => $image
    ];

    dd($api->uploadImage('post' , 'api/upload' , $data));

});


