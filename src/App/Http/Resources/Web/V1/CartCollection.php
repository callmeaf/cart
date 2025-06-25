<?php

namespace Callmeaf\Cart\App\Http\Resources\Web\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @extends ResourceCollection<CartResource>
 */
class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, CartResource>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
