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
    public function cartProduct()
    {
        return $this->belongsTo(CartProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    public function getTotal(): float|int
    {
        $sum=0;
        foreach($this->products as $product){
            $sum +=  $product->price * $product->pivot->quantity;
        }
        return $sum;
    }
    public function getSum()
    {
        $sum=0;
        foreach($this->products as $product){
            $sum +=  $product->pivot->quantity;
        }
        return $sum;
    }
}
