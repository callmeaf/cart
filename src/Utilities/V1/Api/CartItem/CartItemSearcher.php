<?php

namespace Callmeaf\Cart\Utilities\V1\Api\CartItem;

use Callmeaf\Base\Utilities\V1\Contracts\SearcherInterface;
use Illuminate\Database\Eloquent\Builder;

class CartItemSearcher implements SearcherInterface
{
    public function apply(Builder $query, array $filters = []): void
    {
        $filters = collect($filters)->filter(fn($item) => strlen(trim($item)));
//        if($value = $filters->get('title')) {
//            $query->where('title','like',searcherLikeValue($value));
//        }
    }
}