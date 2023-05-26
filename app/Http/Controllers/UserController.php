<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function signup()
    {
        return view('signup');
    }
    public function postSignUp(SignupRequest $request)
    {
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

    public function postSignIn(SignInRequest $request)
    {
        if (!Auth::attempt($request->validated())){
            return back()
                ->withInput()
                ->withErrors([
                    'email'=>'Неверный email или пароль'
                ]);
        }
        return redirect()->route('welcome');
    }
}
