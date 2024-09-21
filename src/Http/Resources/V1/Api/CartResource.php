<?php

namespace Callmeaf\Cart\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user_id' => fn() => $this->user_id,
            'type' => fn() => $this->type,
            'type_text' => fn() => $this->typeText,
            'created_at' => fn() => $this->created_at,
            'created_at_text' => fn() => $this->createdAtText,
            'updated_at' => fn() => $this->updated_at,
            'updated_at_text' => fn() => $this->updatedAtText,
            'deleted_at' => fn() => $this->deleted_at,
            'deleted_at_text' => fn() => $this->deletedAtText,
            'user' => fn() => $this->user ? new (config('callmeaf-user.model_resource'))($this->user,only: $this->only['!user'] ?? []) : null,
            'items' => fn() => $this->items->count() ? new (config('callmeaf-cart-items.model_resource_collection'))($this->items,only: $this->only['!items'] ?? []) : null,
        ],only: $this->only);
    }
}
