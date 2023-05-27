<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $categories = Category::get();
        $products = Product::get();
        return view('home', compact('categories', 'products'));
    }
    public function category($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        $category = Category::where('id', $categoryId)->first();
        return view('category',compact('category', 'products'));
    }
}
