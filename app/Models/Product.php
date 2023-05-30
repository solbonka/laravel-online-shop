<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cartProduct()
    {
        return $this->belongsTo(CartProduct::class);
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }
    public function getPriceSum()
    {
        if (!is_null($this->pivot)){
            return $this->pivot->quantity * $this->price;
        }
        return $this->price;
    }
}
