<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function signup()
    {
        return view('signup');
    }
    public function postSignUp(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string|min:2',
            'firstname' => 'required|string|min:2',
            'patronymic' => 'required|string|min:2',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'lastname' =>$request->lastname,
            'firstname' =>$request->firstname,
            'patronymic' =>$request->patronymic,
            'email' =>$request->email,
            'password' =>Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('home');
    }
    public function signin(){
        return view('signin');
    }

    public function postSignIn(Request $request){
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8',
        ]);
        if (!Auth::attempt($credentials)){
            return back()
                ->withInput()
                ->withErrors([
                    'email'=>'Invalid email or password.'
                ]);
        }
        return redirect()->route('welcome');
    }

}
