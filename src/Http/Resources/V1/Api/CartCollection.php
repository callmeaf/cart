<?php

namespace Callmeaf\Cart\Http\Resources\V1\Api;

use Callmeaf\Media\Http\Resources\V1\Api\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class CartCollection extends ResourceCollection
{
    public function __construct($resource,protected array|int $only = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(fn($cart) => toArrayResource(data: [
                'id' => fn() => $cart->id,
                'user_id' => fn() => $cart->user_id,
                'type' => fn() => $cart->type,
                'type_text' => fn() => $cart->typeText,
                'created_at' => fn() => $cart->created_at,
                'created_at_text' => fn() => $cart->createdAtText,
                'updated_at' => fn() => $cart->updated_at,
                'updated_at_text' => fn() => $cart->updatedAtText,
                'deleted_at' => fn() => $cart->deleted_at,
                'deleted_at_text' => fn() => $cart->deletedAtText,
                'user' => fn() => $cart->user ? new (config('callmeaf-user.model_resource'))($cart->user,only: $this->only['!user'] ?? []) : null,
                'items' => fn() => $cart->items->count() ? new (config('callmeaf-cart-items.model_resource_collection'))($cart->items,only: $this->only['!items'] ?? []) : null,
            ],only: $this->only)),
        ];
    }
}
