<?php

namespace Callmeaf\Cart\Http\Resources\V1\Api;

use Callmeaf\Media\Http\Resources\V1\Api\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class CartItemCollection extends ResourceCollection
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
            'data' => $this->collection->map(fn($cartItem) => toArrayResource(data: [
                'id' => fn() => $cartItem->id,
                'cart_id' => fn() => $cartItem->cart_id,
                'variation_id' => fn() => $cartItem->variation_id,
                'qty' => fn() => $cartItem->qty,
                'created_at' => fn() => $cartItem->created_at,
                'created_at_text' => fn() => $cartItem->createdAtText,
                'updated_at' => fn() => $cartItem->updated_at,
                'updated_at_text' => fn() => $cartItem->updatedAtText,
                'deleted_at' => fn() => $cartItem->deleted_at,
                'deleted_at_text' => fn() => $cartItem->deletedAtText,
                'cart' => fn() => $cartItem->cart ? new (config('callmeaf-cart.model_resource'))($cartItem->cart,only: $this->only['!cart'] ?? []) : null,
                'variation' => fn() => $cartItem->variation ? new (config('callmeaf-variation.model_resource'))($cartItem->variation,only: $this->only['!variation'] ?? []) : null,
            ],only: $this->only)),
        ];
    }
}
