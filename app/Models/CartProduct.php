<?php

namespace App\Models;

use App\Events\CartProductSavingEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartProduct extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    protected $dispatchesEvents = [
        'saving' => CartProductSavingEvent::class
    ];

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function create(int $cartId, int $productId)
    {
        DB::select(
            "INSERT INTO cart_products (cart_id, product_id)
                VALUES ($cartId, $productId)
                ON CONFLICT (cart_id, product_id)
                DO UPDATE SET quantity = cart_products.quantity+1"
        );
        return CartProduct::where('cart_id', $cartId)->where('product_id', $productId)->first();
    }


    public function getPriceSum()
    {
        return $this->quantity * $this->product->price;
    }
}
