<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;
use App\Http\Controllers\AuthController;

class AuthMiddleware
{
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $uid = AuthController::get_session_user($request);
        if (!$uid || !$user = User::find($uid)) {
            return redirect()->route('login');
        }
        $this->auth->guard($guard)->setUser($user);
        /*if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }*/

        return $next($request);
    }
}
