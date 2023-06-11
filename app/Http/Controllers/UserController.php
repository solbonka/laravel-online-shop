<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function signup()
    {
        return view('signup');
    }

    /**
     * @param SignUpRequest $request
     * @return RedirectResponse
     */
    public function postSignUp(SignUpRequest $request): RedirectResponse
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

    /**
     * @return Factory|View|Application
     */
    public function signin(): Factory|View|Application
    {
        return view('signin');
    }

    /**
     * @throws ValidationException
     */
    public function postSignIn(SignInRequest $request): RedirectResponse
    {
        if (!Auth::attempt($request->validated())) {
            throw ValidationException::withMessages([
                'email' => 'Неверный email или пароль'
            ]);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
