<?php

namespace App\Http\Controllers;

use App\Events\CartProductSavingEvent;
use App\Http\Requests\ProductRequest;
use App\Models\Cart;
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

        return json_encode([
            'quantity'    => $cartProduct->quantity,
            'priceSum'    => $cartProduct->getPriceSum(),
            'totalSum'    => $cart->getTotal(),
            'quantitySum' => $cart->getSum(),
        ]);
    }

    public function remove(ProductRequest $request): bool|string
    {
        $user = Auth::user();
        $productId = $request->productId;

        /** @var Cart $cart */
        $cart = $user->cart()->first();
        $cartProduct = $cart->getCartProduct($productId);

        $cartProduct->quantity--;

        $cartProduct->save();

        return json_encode([
            'quantity'    => $cartProduct->quantity,
            'priceSum'    => $cartProduct->getPriceSum(),
            'totalSum'    => $cart->getTotal(),
            'quantitySum' => $cart->getSum(),
        ]);
    }
}
