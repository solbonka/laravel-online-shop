<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\CartProduct;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function cart(): Factory|View|Application
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $cartProducts = CartProduct::get()->where('cart_id', $cart->id);
        return view('cart', compact('cartProducts', 'cart'));
    }

    public function add(ProductRequest $request): string
    {
        $user = Auth::user();

        $productId = (int)$request->productId;

        $cartProduct = $this->cartService->add($user, $productId);

        return json_encode([
            'quantity' => $cartProduct->quantity,
            'priceSum' => $cartProduct->getPriceSum(),
            'totalSum' => $cartProduct->cart->getTotal(),
            'quantitySum' => $cartProduct->cart->getSum(),
        ]);
    }

    public function remove(ProductRequest $request): bool|string
    {
        $user = Auth::user();

        $productId = $request->productId;

        $cartProduct = $this->cartService->remove($user, $productId);

        return json_encode([
            'quantity' => $cartProduct->quantity,
            'priceSum' => $cartProduct->getPriceSum(),
            'totalSum' => $cartProduct->cart->getTotal(),
            'quantitySum' => $cartProduct->cart->getSum(),
        ]);
    }
}
