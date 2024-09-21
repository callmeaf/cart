<?php

namespace Callmeaf\Cart\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function __construct($resource,protected array|int $only = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return toArrayResource(data: [
            'id' => fn() => $this->id,
            'cart_id' => fn() => $this->cart_id,
            'variation_id' => fn() => $this->variation_id,
            'qty' => fn() => $this->qty,
            'created_at' => fn() => $this->created_at,
            'created_at_text' => fn() => $this->createdAtText,
            'updated_at' => fn() => $this->updated_at,
            'updated_at_text' => fn() => $this->updatedAtText,
            'deleted_at' => fn() => $this->deleted_at,
            'deleted_at_text' => fn() => $this->deletedAtText,
            'cart' => fn() => $this->cart ? new (config('callmeaf-cart.model_resource'))($this->cart,only: $this->only['!cart'] ?? []) : null,
            'variation' => fn() => $this->variation ? new (config('callmeaf-variation.model_resource'))($this->variation,only: $this->only['!variation'] ?? []) : null,
        ],only: $this->only);
    }
}
