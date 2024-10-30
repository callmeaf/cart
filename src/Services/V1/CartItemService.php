<?php

namespace Callmeaf\Cart\Services\V1;

use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Cart\Enums\CartType;
use Callmeaf\Cart\Events\CartItemDestroyed;
use Callmeaf\Cart\Exceptions\ItemAlreadyAddedToCartException;
use Callmeaf\Cart\Services\V1\Contracts\CartItemServiceInterface;
use Callmeaf\User\Models\User;
use Callmeaf\User\Services\V1\UserService;
use Callmeaf\Variation\Exceptions\VariationOutOfStockException;
use Callmeaf\Variation\Services\V1\VariationService;
use Carbon\Carbon;
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
        $this->checkVariationStock(variationId: $variationId,qty: $qty);

        $userId = $userId ?? authId();
        /**
         * @var UserService $userService
         */
        $userService = app(config('callmeaf-user.service'));
        /**
         * @var User $user
         */
        $user = $userService->where(column: 'id',valueOrOperation: $userId)->first(columns: ['id'])->getModel();

        $currentCart = $user->currentCart;
        if($this->where([
            'variation_id' => $variationId,
            'cart_id' => $currentCart->id,
        ])->exists()) {
            throw new ItemAlreadyAddedToCartException();
        }

        $this->create(data: [
            'variation_id' => $variationId,
            'qty' => $qty,
            'cart_id' => $currentCart->id,
        ],events: $events);
        return $this;
    }

    public function addToUserFutureCart(int|string $variationId, int $qty = 1, int|string|null $userId = null, ?array $events = []): CartItemService
    {
        $this->checkVariationStock(variationId: $variationId,qty: $qty);
        $userId = $userId ?? authId();
        /**
         * @var UserService $userService
         */
        $userService = app(config('callmeaf-user.service'));
        /**
         * @var User $user
         */
        $user = $userService->where(column: 'id',valueOrOperation: $userId)->first(columns: ['id'])->getModel();

        $futureCart = $this->model ?? $user->futureCart;
        if($this->where([
            'variation_id' => $variationId,
            'cart_id' => $futureCart->id,
        ])->exists()) {
            throw new ItemAlreadyAddedToCartException();
        }

        $this->create(data: [
            'variation_id' => $variationId,
            'qty' => $qty,
            'cart_id' => $futureCart->id,
        ],events: $events);
        return $this;
    }

    public function updateUserCurrentCart(?int $qty = 1, ?array $events = []): self
    {
        if($qty < 1 || is_null($qty)) {
            $this->delete(events: $events);
        } else {
            $this->update([
                'qty' => $qty,
            ],events: $events);
        }
        return $this;
    }

    public function checkVariationStock(int|string $variationId, int $qty = 1): bool
    {
        /**
         * @var VariationService $variationService
         */
        $variationService = app(config('callmeaf-variation.service'));
        $variation = $variationService->where(column: 'id',valueOrOperation: $variationId)->first(columns: ['title','stock'])->getModel();
        if($variation->isEmpty($qty)) {
            throw new VariationOutOfStockException(__('callmeaf-variation::v1.errors.out_of_stock', ['title' => $variation->title]));
        }
        return true;
    }
}
