<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name'); //refers to name attribute in form i.e. name="name" in form
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); //encrypts pw using algorithm called bcrypt
        
        // wk 9 lecture: associate user with particular role
        // method 1
        // $user->role_id = Role::where('slug', '=', 'user')->first()->id; 

        // method 2
        // $userRole = Role::where('slug', '=', 'user')->first();
        $userRole = Role::getUser(); // equivalent refactored way to write above statement; can move some logic to the Role model and call that here; general tip: create custom methods on model to encapsulate something more complex
        
        // $user->role_id = $userRole->id; 
        $user->role()->associate($userRole);
        
        $user->save();

        //Use Auth class to login and keep track of user in session
        Auth::login($user);
        return redirect()->route('profile.index');
    }
}
