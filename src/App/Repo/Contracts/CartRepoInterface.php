<?php

namespace Callmeaf\Cart\App\Repo\Contracts;

use Callmeaf\Base\App\Repo\Contracts\BaseRepoInterface;
use Callmeaf\Cart\App\Models\Cart;
use Callmeaf\Cart\App\Http\Resources\Api\V1\CartCollection;
use Callmeaf\Cart\App\Http\Resources\Api\V1\CartResource;

/**
 * @extends BaseRepoInterface<Cart,CartResource,CartCollection>
 */
interface CartRepoInterface extends BaseRepoInterface
{

}
