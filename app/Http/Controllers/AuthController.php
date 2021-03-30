<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //attempt attempts to login user and returns boolean accordingly
        $loginWasSuccessful = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($loginWasSuccessful) {
            return redirect()->route('profile.index');
        }
        else {
            return redirect()->route('auth.loginForm')->with('error', 'Invalid Credentials.');
        }
    }

    public function logout()
    {
        //Destroy the session and destroy the cookie
        Auth::logout();
        return redirect()->route('eloquent_album.index');
    }
}
