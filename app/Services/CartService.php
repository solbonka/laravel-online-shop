<?php

namespace App\Services;

use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartService
{
    /**
     * @throws Throwable
     */
    public function add(User $user, int $productId)
    {
        DB::beginTransaction();
        try{
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
            $cartProduct = CartProduct::create($cart->id, $productId);
        } catch (Throwable $exception){
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $cartProduct;
    }

    public function remove(User $user, int $productId)
    {
        $cart = $user->cart()->first();
        $cartProduct = $cart->getCartProduct($productId);
        $cartProduct->quantity--;
        $cartProduct->save();
        return $cartProduct;
    }
}
