<?php

namespace Callmeaf\Cart\Services\V1\Contracts;

use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Cart\Services\V1\CartItemService;

interface CartItemServiceInterface extends BaseServiceInterface
{
    public function addToUserCurrentCart(string|int $variationId,int $qty = 1,string|int|null $userId = null,?array $events = []): CartItemService;
}
