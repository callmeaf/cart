<?php

namespace Callmeaf\Cart\Events;

use Callmeaf\Cart\Models\Cart;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartShowed
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Cart $cart)
    {

    }
}
