<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function signup()
    {
        return view('signup');
    }

    public function postSignUp(SignUpRequest $request)
    {
        $user = User::create([
            'lastname' =>$request->lastname,
            'firstname' =>$request->firstname,
            'patronymic' =>$request->patronymic,
            'email' =>$request->email,
            'password' =>Hash::make($request->password),
        ]);
        SendEmailJob::dispatch($user)->onQueue('default');
        Auth::login($user);
        return redirect()->route('verification.notice');
    }

    public function signin()
    {
        return view('signin');
    }

    /**
     * @throws ValidationException
     */
    public function postSignIn(SignInRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            throw ValidationException::withMessages([
                'email' => 'Неверный email или пароль'
            ]);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
