<?php

namespace App\Http\Controllers;

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
    public function main()
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $categories = Category::get();
        return view('home', compact('categories', 'cart'));
    }
    public function category($categoryId)
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $category = Category::where('id', $categoryId)->first();
        return view('category',compact('category', 'cart'));
    }
}
