<?php

return [
    'model' => \Callmeaf\Cart\Models\CartItem::class,
    'model_resource' => \Callmeaf\Cart\Http\Resources\V1\Api\CartItemResource::class,
    'model_resource_collection' => \Callmeaf\Cart\Http\Resources\V1\Api\CartItemCollection::class,
    'service' => \Callmeaf\Cart\Services\V1\CartItemService::class,
    'default_values' => [
        'qty' => 1,
    ],
    'events' => [
        \Callmeaf\Cart\Events\CartItemStored::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartItemShowed::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartItemUpdated::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartItemDestroyed::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartItemRestored::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartItemTrashed::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartItemForceDestroyed::class => [
            // listeners
        ],
    ],
    'validations' => [
        'cart_item' => \Callmeaf\Cart\Utilities\V1\Api\CartItem\CartItemFormRequestValidator::class,

    ],
    'resources' => [
        'cart_item' => \Callmeaf\Cart\Utilities\V1\Api\CartItem\CartItemResources::class,
    ],
    'controllers' => [
        'cart_items' => \Callmeaf\Cart\Http\Controllers\V1\Api\CartItemController::class,
    ],
    'form_request_authorizers' => [
        'cart_item' => \Callmeaf\Cart\Utilities\V1\Api\CartItem\CartItemFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'cart_item' => \Callmeaf\Cart\Utilities\V1\Api\CartItem\CartItemControllerMiddleware::class,
    ],
    'searcher' => \Callmeaf\Cart\Utilities\V1\Api\CartItem\CartItemSearcher::class,
];
