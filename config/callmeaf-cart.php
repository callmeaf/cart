<?php

return [
    'model' => \Callmeaf\Cart\Models\Cart::class,
    'model_resource' => \Callmeaf\Cart\Http\Resources\V1\Api\CartResource::class,
    'model_resource_collection' => \Callmeaf\Cart\Http\Resources\V1\Api\CartCollection::class,
    'service' => \Callmeaf\Cart\Services\V1\CartService::class,
    'default_values' => [
        'type' => \Callmeaf\Cart\Enums\CartType::CURRENT,
    ],
    'events' => [
        \Callmeaf\Cart\Events\CartIndexed::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartStored::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartShowed::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartUpdated::class => [
            // listeners
        ],
        \Callmeaf\Cart\Events\CartDischarged::class => [
            // listeners
        ],

    ],
    'validations' => [
        'cart' => \Callmeaf\Cart\Utilities\V1\Api\Cart\CartFormRequestValidator::class,
    ],
    'resources' => [
        'cart' => \Callmeaf\Cart\Utilities\V1\Api\Cart\CartResources::class,
    ],
    'controllers' => [
        'carts' => \Callmeaf\Cart\Http\Controllers\V1\Api\CartController::class,
    ],
    'form_request_authorizers' => [
        'cart' => \Callmeaf\Cart\Utilities\V1\Api\Cart\CartFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'cart' => \Callmeaf\Cart\Utilities\V1\Api\Cart\CartControllerMiddleware::class,
    ],
    'searcher' => \Callmeaf\Cart\Utilities\V1\Api\Cart\CartSearcher::class,
];
