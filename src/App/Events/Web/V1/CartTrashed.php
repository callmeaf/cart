<?php

namespace Callmeaf\Cart\App\Events\Web\V1;

use Callmeaf\Cart\App\Models\Cart;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartTrashed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param Collection<Cart> $carts
     * Create a new event instance.
     */
    public function __construct(Collection $carts)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
