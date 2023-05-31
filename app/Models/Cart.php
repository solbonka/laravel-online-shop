<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->using(CartProduct::class);
    }
    public function getTotal(): float|int
    {
        $sum=0;
        foreach($this->cartProducts as $cartProduct){
            $sum +=  $cartProduct->product->price * $cartProduct->quantity;
        }
        return $sum;
    }
    public function getSum()
    {
        $sum=0;
        foreach($this->cartProducts as $cartProduct){
            $sum +=  $cartProduct->quantity;
        }
        return $sum;
    }

}
