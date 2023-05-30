<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $fillable = ['quantity'];
    use HasFactory;
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getProducts($cart)
    {
        return $this->products();
    }
    public function getCarts($product)
    {
        return $this->carts();
    }

}
