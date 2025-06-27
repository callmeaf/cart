<?php

namespace Callmeaf\Cart\App\Http\Resources\Api\V1;

use Callmeaf\Cart\App\Models\Cart;
use Callmeaf\CartItem\App\Repo\Contracts\CartItemRepoInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Cart $resource
 */
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var CartItemRepoInterface $cartItemRepo
         */
        $cartItemRepo = app(CartItemRepoInterface::class);
        return [
            'type' => $this->type,
            'type_text' => $this->typeText,
            'created_at' => $this->created_at,
            'created_at_text' => $this->createdAtText(),
            'updated_at' => $this->updated_at,
            'updated_at_text' => $this->updatedAtText(),
            'deleted_at' => $this->deleted_at,
            'deleted_at_text' => $this->deletedAtText(),
            'items' => $cartItemRepo->toResourceCollection($this->whenLoaded('items')),
        ];
    }
}
