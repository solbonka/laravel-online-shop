<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SendController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::middleware('guest')->group(function(){
    Route::controller(UserController::class)->group(function() {
        Route::get('/signup', 'signup')->name('signup');
        Route::get('/signin', 'signin')->name('signin');
        Route::post('/signup', 'postSignUp');
        Route::post('/signin', 'postSignIn');
    });
});

Route::middleware(['auth','verified'])->group(function(){
    Route::controller(MainController::class)->group(function() {
        Route::get('/home', 'main')->name('home');
        Route::get('/category/{categoryId}', 'category')->name('{categoryId}');
    });
    Route::controller(CartController::class)->group(function() {
        Route::get('/cart', 'cart')->name('cart');
        Route::post('/add', 'add')->name('add');
        Route::post('/remove', 'remove')->name('remove');
    });
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
