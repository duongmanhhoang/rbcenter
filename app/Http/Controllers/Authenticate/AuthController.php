<?php

namespace App\Http\Controllers\Authenticate;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    public static function user()
    {
        if (session('admin')) {
            $id = session('admin');
        } elseif (Cookie::get('cookie_admin')) {
            $cookie_admin = Cookie::get('cookie_admin');
            $id = json_decode($cookie_admin)->id;

        }
        $api = new Api();
        $auth_user = $api->sendRequest('get', '/api/users/' . $id)->data;

        return $auth_user;
    }
}
