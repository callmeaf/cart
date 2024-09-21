<?php

namespace Callmeaf\Cart\Events;

use Callmeaf\Cart\Models\CartItem;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartItemUpdated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public CartItem $cartItem)
    {

    }
}
