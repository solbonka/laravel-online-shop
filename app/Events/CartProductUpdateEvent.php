<?php

namespace App\Events;

use App\Models\CartProduct;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class cartProductUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CartProduct $cartProduct;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CartProduct $cartProduct)
    {
        $this->cartProduct = $cartProduct;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
