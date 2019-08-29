<?php

namespace App\Http\Middleware;

use App\Api\Api;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class Admin
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
        if($request->cookie('cookie_admin') || session('admin')){
            if($request->cookie('cookie_admin')){
                $cookie_admin = json_decode(Cookie::get('cookie_admin'));
                $api = new Api();
                $user = $api->sendRequest('get' , 'api/users/'.$cookie_admin->id)->data;
                if($user->remember_token == $cookie_admin->remember_token){
                    return $next($request);
                }
                else{
                    return redirect(route('admin.login'));
                }

            }
            return $next($request);
        }
        else{
            return redirect(route('admin.login'));
        }

    }
}
