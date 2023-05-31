<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $cartProducts = CartProduct::get()->where('cart_id', $cart->id);
        return view('cart', compact('cartProducts', 'cart'));
    }
    public function add(Request $request):string
    {
        $user = Auth::user();
        $productId = $request->productId;
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        $cartProduct = CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->get()->first();
        if ($cartProduct){
            CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->update(['quantity' => $cartProduct->quantity + 1]);
        }
        else{
            CartProduct::create(['cart_id' => $cart->id, 'product_id' => $productId, 'quantity' => 1,]);
        }
        $cartProduct = CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->get()->first();
        $quantity = $cartProduct->quantity;
        $priceSum = $cartProduct->getPriceSum();
        $totalSum = $cart->getTotal();
        $quantitySum = $cart->getSum();
        return json_encode(compact('priceSum', 'quantity','totalSum','quantitySum'));

    }
    public function remove(Request $request): bool|string
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $productId = $request->productId;
        $quantity = 0;
        $priceSum = 0;
        $cartProduct = CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->get()->first();
        if ($cartProduct){
            if ($cartProduct->quantity > 1){
                CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->update(['quantity' => $cartProduct->quantity - 1]);
                $cartProduct = CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->get()->first();
                $quantity = $cartProduct->quantity;
                $priceSum = $cartProduct->getPriceSum();
            }
            else{
                CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->delete();

            }
        }


        $totalSum = $cart->getTotal();
        $quantitySum = $cart->getSum();

        return json_encode(compact('totalSum', 'quantitySum', 'priceSum', 'quantity'));
    }
}
