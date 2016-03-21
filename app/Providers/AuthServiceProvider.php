<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AuthController;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        /*$this->app['auth']->viaRequest('api', function ($request) {
            //all this crap doesn't do anything, I can't get this goddamn callback to fire and I have no idea why.
            //I'm just going to implement my own middleware.
            $uid = AuthController::get_session_user($request);
            if ($uid) {
                return User::find($uid);
            }
            return null;
        });*/
    }
}
