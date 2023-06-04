<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];
    use HasFactory;
    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getPriceSum()
    {
        if (!is_null($this)){
            return $this->quantity * $this->product->price;
        }
        return 0;
    }
}
