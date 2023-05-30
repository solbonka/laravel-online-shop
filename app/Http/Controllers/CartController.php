<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        return view('cart', compact('cart'));
    }
    public function add(Request $request):string
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        $productId = $request->productId;
        if ($cart->products->contains($productId)){
            $product = $cart->products()->where('product_id', $productId)->first();
            $cartProduct = $product->pivot;
            $cartProduct->quantity++;
            $cartProduct->update();
            $quantity = $cartProduct->quantity;
            $priceSum = $product->getPriceSum();
        }
        else{
            $cart->products()->attach($productId);
            $product = $cart->products()->where('product_id', $productId)->first();
            $cartProduct = $product->pivot;
            $quantity = $cartProduct->quantity;
            $priceSum = $product->price;
        }
        $quantitySum = $cart->getSum()+1;
        $totalSum = $cart->getTotal()+$product->price;


        return json_encode(compact('totalSum', 'quantitySum', 'priceSum', 'quantity', 'cartProduct'));

    }
    public function remove(Request $request): bool|string
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $productId = $request->productId;
        $product = $cart->products()->where('product_id', $productId)->first();
        $quantity = 0;
        if ($cart->products->contains($productId)){
            $cartProduct = $product->pivot;
            if ($cartProduct->quantity < 2){
                $cart->products()->detach($productId);
                $cartProduct=null;
            }
            else{
                $cartProduct->quantity--;
                $cartProduct->update();
                $quantity = $cartProduct->quantity;
            }
        }

        $quantitySum = $cart->getSum()-1;
        $priceSum = $product->getPriceSum();
        $totalSum = $cart->getTotal()-$product->price;

        return json_encode(compact('totalSum', 'quantitySum', 'priceSum', 'quantity', 'cartProduct'));
    }
}
