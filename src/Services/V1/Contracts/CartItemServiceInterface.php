<?php

namespace Callmeaf\Cart\Services\V1\Contracts;

use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Cart\Services\V1\CartItemService;
use Carbon\Carbon;

interface CartItemServiceInterface extends BaseServiceInterface
{
    public function addToUserCurrentCart(string|int $variationId,int $qty = 1,string|int|null $userId = null,?array $events = []): CartItemService;
    public function addToUserFutureCart(string|int $variationId,int $qty = 1,string|int|null $userId = null,?array $events = []): CartItemService;
    public function updateUserCurrentCart(?int $qty = 1,?array $events = []): CartItemService;
    public function checkVariationStock(int|string $variationId, int $qty = 1): bool;
}
