<?php

namespace App\Listeners;

use App\Events\cartProductUpdateEvent;
use App\Models\CartProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class cartProductUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\cartProductUpdateEvent  $event
     * @return void
     */
    public function handle(cartProductUpdateEvent $event)
    {
        $event->cartProduct->quantity--;
        CartProduct::where('cart_id', $event->cartProduct->cart_id)->where('product_id', $event->cartProduct->product_id)->update(['quantity' => $event->cartProduct->quantity]);
    }
}
