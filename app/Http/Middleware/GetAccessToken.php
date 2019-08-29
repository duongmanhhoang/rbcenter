<?php

namespace App\Http\Middleware;

use App\Api\Api;
use Closure;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class GetAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Cache::has('access_token') || Cache::get('access_token') == null){
            $client = new Api();
            $tokenObj = $client->sendRequest('post' ,'oauth/token',
                [
                    "grant_type"  => "password",
                    "username" => "manhhoang3151996@gmail.com",
                    "password" => "manhhoang664096",
                    "client_id" => "2",
                    "client_secret" => "woBIo9kex65mvuJTCXVW3yjhxnYD6QFo0LabXPNE"
                ]);

            Cache::put('access_token' , "Bearer " . $tokenObj->access_token, 60*24*30);
        }


        if(!Cache::has('image_access_token') || Cache::get('image_access_token') == null){
            $client = new Api();
            $tokenObj = $client->uploadImage('post' ,'oauth/token',
                [
                    "grant_type"  => "password",
                    "username" => "manhhoang3151996@gmail.com",
                    "password" => "manhhoang664096",
                    "client_id" => "3",
                    "client_secret" => "OvRo6G35VASkPdoAqIvfdgYA4qfJSS6TqL8AecNg"
                ]);
            Cache::put('image_access_token' , "Bearer " . $tokenObj->access_token, 60*24*30);
        }
        return $next($request);
    }
}
