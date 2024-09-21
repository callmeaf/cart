<?php

namespace Callmeaf\Cart\Services\V1\Contracts;

use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface extends BaseServiceInterface
{
    /**
     * variationsData including variation id and qty -> [
     *      [
     *          'variation_id' => 1,
     *          'qty' => 1,
     *      ],
     * ]
     *
     */
    public function createItemsViaVariationsData(array $variationsData): Collection;
}
