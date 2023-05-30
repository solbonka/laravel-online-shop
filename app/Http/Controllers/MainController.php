<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function main(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $categories = Category::get();
        return view('home', compact('categories', 'cart'));
    }
    public function category($categoryId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $category = Category::where('id', $categoryId)->first();
        return view('category',compact('category', 'cart'));
    }
}
