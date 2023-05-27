<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
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


Route::get('/signup', [UserController::class, 'signup'])->middleware('guest')->name('signup');
Route::post('/signup', [UserController::class, 'postSignUp'])->middleware('guest');
Route::get('/signin', [UserController::class, 'signin'])->middleware('guest')->name('signin');
Route::post('/signin', [UserController::class, 'postSignIn'])->middleware('guest');
Route::get('/home', [MainController::class, 'main'])->middleware('auth')->name('home');
Route::get('/category/{categoryId}', [MainController::class, 'category'])->middleware('auth')->name('{categoryId}');
