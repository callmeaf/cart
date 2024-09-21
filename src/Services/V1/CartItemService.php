<?php

namespace Callmeaf\Cart\Services\V1;

use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Cart\Services\V1\Contracts\CartItemServiceInterface;
use Callmeaf\User\Models\User;
use Callmeaf\User\Services\V1\UserService;
use Callmeaf\Variation\Exceptions\VariationOutOfStockException;
use Callmeaf\Variation\Services\V1\VariationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemService extends BaseService implements CartItemServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null, ?JsonResource $resource = null, ?ResourceCollection $resourceCollection = null, array $defaultData = [],?string $searcher = null)
    {
        parent::__construct($query, $model, $collection, $resource, $resourceCollection, $defaultData,$searcher);
        $this->query = app(config('callmeaf-cart-items.model'))->query();
        $this->resource = config('callmeaf-cart-items.model_resource');
        $this->resourceCollection = config('callmeaf-cart-items.model_resource_collection');
        $this->defaultData = config('callmeaf-cart-items.default_values');
        $this->searcher = config('callmeaf-cart-items.searcher');
    }

    public function addToUserCurrentCart(int|string $variationId, int $qty = 1, int|string|null $userId = null,?array $events = []): self
    {
        /**
         * @var VariationService $variationService
         */
        $variationService = app(config('callmeaf-variation.service'));
        $variation = $variationService->where(column: 'id',valueOrOperation: $variationId)->first(columns: ['title','stock'])->getModel();
        if($variation->isEmpty($qty)) {
            throw new VariationOutOfStockException(__('callmeaf-variation::v1.errors.out_of_stock', ['title' => $variation->title]));
        }
        $userId = $userId ?? authId();
        /**
         * @var UserService $userService
         */
        $userService = app(config('callmeaf-user.service'));
        /**
         * @var User $user
         */
        $user = $userService->where(column: 'id',valueOrOperation: $userId)->first(columns: ['id'])->getModel();
        $this->create(data: [
            'variation_id' => $variationId,
            'qty' => $qty,
            'cart_id' => $user->currentCart->id,
        ],events: $events);
        return $this;
    }

}
