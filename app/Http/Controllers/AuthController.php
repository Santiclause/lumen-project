<?php

namespace App\Http\Controllers;

use Cache;
use DateTime;
use DateInterval;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public static function get_session_cookie(Request $request)
    {
        $cookie_string = $request->header('Cookie');
        if ($cookie_string) {
            $cookies = explode('; ', $cookie_string);
            foreach ($cookies as $c) {
                list($ckey, $cval) = array_pad(explode('=', $c, 2), 2, '');
                if ($ckey == 'sid') {
                    return $cval;
                }
            }
        }
        return false;
    }
    
    public static function get_session_user(Request $request)
    {
        $sid = static::get_session_cookie($request);
        return $sid ? Cache::get($sid) : false;
    }
    
    public function login(Request $request)
    {
        if (static::get_session_user($request)) {
            //we've received a login attempt from a user that already has a session cookie that exists in our cache. just send them to dashboard
            return redirect()->route('dashboard');
        }
        if (!$request->has('email') || !$request->has('password')) {
            return view('login')->with('error_msg', 'You must provide all the required fields.');
        }
        $email = $request->input('email');
        $pass = $request->input('password');
        //Using Eloquent as our ORM means we don't need to sanitize, apparently
        $user = User::where('email', $email)->first();
        //User shouldn't know which failed
        //Let's also just apply handwavium and pretend that we're limiting access attempts to combat brute forcing, or something
        if (!$user || !password_verify($pass, $user->password)) {
            return view('login')->with('error_msg', "Invalid user credentials.");
        }
        //generate securely random session IDs until we get one without a collision
        //there shouldn't ever be a collision (statistically speaking), but it doesn't hurt to be safe
        do {
            $token = bin2hex(openssl_random_pseudo_bytes(16));
        } while(Cache::has($token));
        //should a user be able to have multiple auth sessions? (aka multiple devices, multiple browsers, etc)
        //let's decide on "yes" for now
        $expiry = (new DateTime)->add(new DateInterval("P7D"));
        Cache::put($token, $user->id, $expiry);
        //Kind of frustrating that I have to homebake this
        $cookie = "sid=$token; expires={$expiry->format(DATE_COOKIE)}; HttpOnly; path=/";
        return redirect()->route('dashboard')->header("Set-Cookie", $cookie);
    }
    
    public function logout(Request $request)
    {
        if ($sid = static::get_session_cookie($request)) {
            Cache::forget($sid);
        }
        return redirect()->route('main')->header("Set-Cookie", 'sid=; expires=Thu, 01 Jan 1970 00:00:00 GMT; HttpOnly; path=/');
    }
}