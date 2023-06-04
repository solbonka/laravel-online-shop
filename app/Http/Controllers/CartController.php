<?php

namespace App\Http\Controllers;

use App\Events\addProductUpdateEvent;
use App\Events\removeProductUpdateEvent;
use App\Models\CartProduct;
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
        $cartProduct = $cart->cartProducts()->where('product_id', $productId)->first();
        if ($cartProduct){
            event(new addProductUpdateEvent($cartProduct));
        }
        else{
            CartProduct::create(['cart_id' => $cart->id, 'product_id' => $productId, 'quantity' => 1,]);
        }
        $cartProduct = $cart->cartProducts()->where('product_id', $productId)->first();
        $quantity = $cartProduct->quantity;
        $priceSum = $cartProduct->getPriceSum();
        $totalSum = $cart->getTotal();
        $quantitySum = $cart->getSum();
        return json_encode(compact('totalSum', 'quantitySum', 'priceSum', 'quantity'));

    }
    public function remove(Request $request): bool|string
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $productId = $request->productId;
        $cartProduct = $cart->cartProducts()->where('product_id', $productId)->first();
        if ($cartProduct->quantity > 1){
            event(new removeProductUpdateEvent($cartProduct));
        }
        else{
            CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
        }
        $cartProduct = $cart->cartProducts()->where('product_id', $productId)->first();
        if (!$cartProduct) {
            $quantity = 0;
            $priceSum = 0;
        } else {
            $quantity = $cartProduct->quantity;
            $priceSum = $cartProduct->getPriceSum();
        }
        $totalSum = $cart->getTotal();
        $quantitySum = $cart->getSum();
        return json_encode(compact('totalSum', 'quantitySum', 'priceSum', 'quantity'));
    }
}
