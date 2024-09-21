<?php

namespace Callmeaf\Cart\Listeners;

use Callmeaf\Cart\Events\CartStored;
use Callmeaf\Cart\Services\V1\CartService;

class CreateCartItemsViaVariationsData
{
    /**
     * Handle the event.
     *
     * @param CartStored $event
     * @return void
     */
    public function handle(CartStored $event)
    {
        /**
         * @var CartService $cartService
         */
        $cartService = app(config('callmeaf-cart.service'));
        $productService->changeCatsToDefault(productIds: $event->productCategory->products()->pluck('id')->toArray());
    }
}
