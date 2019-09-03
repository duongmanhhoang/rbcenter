<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    function uploadFile($requestFile){
        $filePath = $requestFile->path();
        $fileData = File::get($filePath);
        $fileName = uniqid().'-'.$requestFile->getClientOriginalName();
        Storage::cloud()->put($fileName , $fileData);
        $fileUrl = Storage::cloud()->url($fileName);

        $data = ['url' => $fileUrl, 'file_name' => $fileName];
        return $data;
    }

    function uploadImage($requestImage)
    {
        $imageName = uniqid().'-'.$requestImage->getClientOriginalName();
        $image = base64_encode(file_get_contents($requestImage->path()));
        $data = [
            'imageName' => $imageName,
            'image' => $image
        ];
        $api =new Api();
        $image = $api->uploadImage('post' , 'api/upload' , $data);

        return $image;
    }

    public function deleteFile($name)
    {
        $filename = $name;
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first();
        Storage::cloud()->delete($file['path']);
        return 'File was deleted from Google Drive';
    }
}
