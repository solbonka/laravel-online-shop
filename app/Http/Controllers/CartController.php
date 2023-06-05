<?php

namespace App\Http\Controllers;

use App\Events\cartProductUpdateEvent;
use App\Http\Requests\ProductRequest;
use App\Models\CartProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function cart(): Factory|View|Application
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $cartProducts = CartProduct::get()->where('cart_id', $cart->id);
        return view('cart', compact('cartProducts', 'cart'));
    }

    public function add(ProductRequest $request):string
    {
        $user = Auth::user();
        $productId = (int) $request->productId;
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        $cartProduct = CartProduct::create($cart->id, $productId);
        $quantity = $cartProduct->quantity;
        $priceSum = $cartProduct->getPriceSum();
        $totalSum = $cart->getTotal();
        $quantitySum = $cart->getSum();
        return json_encode(compact('totalSum', 'quantitySum', 'priceSum', 'quantity'));
    }

    public function remove(ProductRequest $request): bool|string
    {
        $user = Auth::user();
        $productId = $request->productId;
        $cart = $user->cart()->first();
        $cartProduct = $cart->getCartProduct($productId);
        if ($cartProduct->quantity > 1){
            event(new cartProductUpdateEvent($cartProduct));
        }
        else{
            CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
        }
        $cartProduct = $cart->getCartProduct($productId);
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
