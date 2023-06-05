<?php

namespace App\Listeners;

use App\Events\CartProductSavingEvent;
use App\Models\CartProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteCartProductListener
{
/**
* Create the event listener.
*
* @return void
*/
public function __construct()
{
}

/**
* Handle the event.
*
* @param  \App\Events\CartProductSavingEvent  $event
* @return void
*/
public function handle(CartProductSavingEvent $event)
    {
        $cartProduct = $event->cartProduct;
        if ($cartProduct->quantity === 0) {
            $cartProduct->delete();
            return false;
        }
    }
}
