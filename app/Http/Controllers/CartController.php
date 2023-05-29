<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart()
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        return view('cart', compact('cart'));
    }
    public function add(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        if ($cart->products->contains($request->productId)){
            $quantityRow = $cart->products()->where('product_id', $request->productId)->first()->pivot;
            $quantityRow->quantity++;
            $quantityRow->update();
        }
        else{
            $cart->products()->attach($request->productId);
        }

        return redirect()->route('cart');
    }
    public function remove(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        if ($cart->products->contains($request->productId)){
            $quantityRow = $cart->products()->where('product_id', $request->productId)->first()->pivot;
            if ($quantityRow->quantity <= 1){
                $cart->products()->detach($request->productId);
            }
            else{
                $quantityRow->quantity--;
                $quantityRow->update();
            }
        }

        return redirect()->route('cart');
    }
}
