<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
        return $fileUrl;
    }
}
