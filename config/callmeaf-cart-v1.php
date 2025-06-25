<?php

use Callmeaf\Base\App\Enums\RequestType;

return [
    'model' => \Callmeaf\Cart\App\Models\Cart::class,
    'route_key_name' => 'id',
    'repo' => \Callmeaf\Cart\App\Repo\V1\CartRepo::class,
    'resources' => [
        RequestType::API->value => [
            'resource' => \Callmeaf\Cart\App\Http\Resources\Api\V1\CartResource::class,
            'resource_collection' => \Callmeaf\Cart\App\Http\Resources\Api\V1\CartCollection::class,
        ],
        RequestType::WEB->value => [
            'resource' => \Callmeaf\Cart\App\Http\Resources\Web\V1\CartResource::class,
            'resource_collection' => \Callmeaf\Cart\App\Http\Resources\Web\V1\CartCollection::class,
        ],
        RequestType::ADMIN->value => [
            'resource' => \Callmeaf\Cart\App\Http\Resources\Admin\V1\CartResource::class,
            'resource_collection' => \Callmeaf\Cart\App\Http\Resources\Admin\V1\CartCollection::class,
        ],
    ],
    'events' => [
        RequestType::API->value => [
            \Callmeaf\Cart\App\Events\Api\V1\CartIndexed::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Api\V1\CartCreated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Api\V1\CartShowed::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Api\V1\CartUpdated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Api\V1\CartDeleted::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Api\V1\CartStatusUpdated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Api\V1\CartTypeUpdated::class => [
                // listeners
            ],
        ],
        RequestType::WEB->value => [
            \Callmeaf\Cart\App\Events\Web\V1\CartIndexed::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Web\V1\CartCreated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Web\V1\CartShowed::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Web\V1\CartUpdated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Web\V1\CartDeleted::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Web\V1\CartStatusUpdated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Web\V1\CartTypeUpdated::class => [
                // listeners
            ],
        ],
        RequestType::ADMIN->value => [
            \Callmeaf\Cart\App\Events\Admin\V1\CartIndexed::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Admin\V1\CartCreated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Admin\V1\CartShowed::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Admin\V1\CartUpdated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Admin\V1\CartDeleted::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Admin\V1\CartStatusUpdated::class => [
                // listeners
            ],
            \Callmeaf\Cart\App\Events\Admin\V1\CartTypeUpdated::class => [
                // listeners
            ],
        ],
    ],
    'requests' => [
        RequestType::API->value => [
            'index' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartIndexRequest::class,
            'store' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartStoreRequest::class,
            'show' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartShowRequest::class,
            'update' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartUpdateRequest::class,
            'destroy' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartDestroyRequest::class,
            'statusUpdate' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartStatusUpdateRequest::class,
            'typeUpdate' => \Callmeaf\Cart\App\Http\Requests\Api\V1\CartTypeUpdateRequest::class,
        ],
        RequestType::WEB->value => [
            'index' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartIndexRequest::class,
            'create' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartCreateRequest::class,
            'store' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartStoreRequest::class,
            'show' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartShowRequest::class,
            'edit' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartEditRequest::class,
            'update' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartUpdateRequest::class,
            'destroy' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartDestroyRequest::class,
            'statusUpdate' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartStatusUpdateRequest::class,
            'typeUpdate' => \Callmeaf\Cart\App\Http\Requests\Web\V1\CartTypeUpdateRequest::class,
        ],
        RequestType::ADMIN->value => [
            'index' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartIndexRequest::class,
            'store' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartStoreRequest::class,
            'show' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartShowRequest::class,
            'update' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartUpdateRequest::class,
            'destroy' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartDestroyRequest::class,
            'statusUpdate' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartStatusUpdateRequest::class,
            'typeUpdate' => \Callmeaf\Cart\App\Http\Requests\Admin\V1\CartTypeUpdateRequest::class,
        ],
    ],
    'controllers' => [
        RequestType::API->value => [
            'cart' => \Callmeaf\Cart\App\Http\Controllers\Api\V1\CartController::class,
        ],
        RequestType::WEB->value => [
            'cart' => \Callmeaf\Cart\App\Http\Controllers\Web\V1\CartController::class,
        ],
        RequestType::ADMIN->value => [
            'cart' => \Callmeaf\Cart\App\Http\Controllers\Admin\V1\CartController::class,
        ],
    ],
    'routes' => [
        RequestType::API->value => [
            'prefix' => 'carts',
            'as' => 'carts.',
            'middleware' => [
                'auth:sanctum'
            ],
        ],
        RequestType::WEB->value => [
            'prefix' => 'carts',
            'as' => 'carts.',
            'middleware' => [
                'route_status:' . \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND
            ],
        ],
        RequestType::ADMIN->value => [
            'prefix' => 'carts',
            'as' => 'carts.',
            'middleware' => [],
        ],
    ],
    'enums' => [
         'status' => \Callmeaf\Cart\App\Enums\CartStatus::class,
         'type' => \Callmeaf\Cart\App\Enums\CartType::class,
    ],
     'exports' => [
        RequestType::API->value => [
            'excel' => \Callmeaf\Cart\App\Exports\Api\V1\CartsExport::class,
        ],
        RequestType::WEB->value => [
            'excel' => \Callmeaf\Cart\App\Exports\Web\V1\CartsExport::class,
        ],
        RequestType::ADMIN->value => [
            'excel' => \Callmeaf\Cart\App\Exports\Admin\V1\CartsExport::class,
        ],
     ],
     'imports' => [
         RequestType::API->value => [
             'excel' => \Callmeaf\Cart\App\Imports\Api\V1\CartsImport::class,
         ],
         RequestType::WEB->value => [
             'excel' => \Callmeaf\Cart\App\Imports\Web\V1\CartsImport::class,
         ],
         RequestType::ADMIN->value => [
             'excel' => \Callmeaf\Cart\App\Imports\Admin\V1\CartsImport::class,
         ],
     ],
];
