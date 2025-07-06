<?php

namespace Callmeaf\Cart\App\Repo\V1;

use Callmeaf\Base\App\Repo\V1\BaseRepo;
use Callmeaf\Cart\App\Http\Resources\Api\V1\CartResource;
use Callmeaf\Cart\App\Models\Cart;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Database\Eloquent\Model;

class CartRepo extends BaseRepo implements CartRepoInterface
{
    public function emptyCart(mixed $id)
    {
        /**
         * @var CartResource $cart
         */
        $cart = $this->findById($id);

        $cart->resource->items()->delete();

        return $cart;
    }
}
