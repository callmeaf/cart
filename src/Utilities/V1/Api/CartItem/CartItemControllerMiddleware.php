<?php

namespace Callmeaf\Cart\Utilities\V1\Api\CartItem;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class CartItemControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum')
        ];
    }
}
