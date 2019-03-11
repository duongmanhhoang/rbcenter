<?php

namespace App\Providers;

use App\Api\Api;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['admin.layouts.header'],
            function ($view) {
                $api = new Api();
                $id = session('admin')->id;
                $auth_user = $api->sendRequest('get' , 'users/'.$id)->data;
                $view->with('auth_user', $auth_user);
            }
        );
    }
}
