<?php

namespace Callmeaf\Cart\Commands;

use Callmeaf\Cart\Enums\CartType;
use Callmeaf\Cart\Events\CartItemDestroyed;
use Callmeaf\Cart\Models\Cart;
use Callmeaf\Cart\Services\V1\CartItemService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RemoveUselessCartItemsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:remove-useless-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unused cart items after {x} minutes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * @var CartItemService $cartItemsService
         */
        $cartItemsService = app(config('callmeaf-cart-items.service'));
        $removeUselessItemsExpiredTime = $removeUselessItemsExpiredTime ?? now()->subMinutes(config('callmeaf-cart-items.remove_useless_cart_items_minutes'));
        $cartItemsService->getQuery()->whereHas('cart',function(Builder $query) {
            $query->ofType(CartType::CURRENT->value);
        })->where('updated_at','<=',$removeUselessItemsExpiredTime->toDateTimeString())->chunkById(20,function(Collection $cartItems) use ($cartItemsService) {
            foreach ($cartItems as $cartItem) {
                $cartItemsService->setModel($cartItem)->delete(events: [
                    CartItemDestroyed::class,
                ]);
            }
        });
    }
}
