<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }
    
    public function create(Request $request)
    {
        if (!$request->has('password') || !$request->has('name') || !$request->has('email')) {
            return "cut that out";
        }
        $user = new User;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $user;
    }
}