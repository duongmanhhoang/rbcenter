<?php

namespace App\Http\Controllers\Authenticate;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function index()
    {

        if (session('admin')) {
            return redirect(route('admin.index'));
        }
        return view('admin.auth.index');
    }

    public function login(LoginRequest $request)
    {
        $api = new Api();
        $data = $request->all();
        try {
            $user = $api->sendRequest('post', '/api/login', $data)->data;
            if ($user->role_id != 1 && $user->role_id != 100) {
                $request->session()->flash('role_error');
                return redirect(route('admin.login'));
            } else {
                if ($request->remember) {
                    $minutes = 50000;
                    $cookie_data = [];
                    $cookie_data['remember_token'] = $user->remember_token;
                    $cookie_data['id'] = $user->id;
                    $cookie_data['role_id'] = $user->role_id;
                    Cookie::queue(Cookie::make('cookie_admin', json_encode($cookie_data), $minutes));

                } else {
                    $request->session()->put('admin', $user);
                }

                return redirect(route('admin.index'));
            }
        } catch (\Exception $e) {
            $request->session()->flash('login_error');
            return redirect(route('admin.login'));
        }
    }

    public function logout(Request $request)
    {
        session()->forget('admin');
        Cookie::queue(Cookie::forget('cookie_admin'));
        return redirect(route('admin.login'));
    }
}
