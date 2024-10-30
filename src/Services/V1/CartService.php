<?php

namespace Callmeaf\Cart\Services\V1;

use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Cart\Services\V1\Contracts\CartServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartService extends BaseService implements CartServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null, ?JsonResource $resource = null, ?ResourceCollection $resourceCollection = null, array $defaultData = [],?string $searcher = null)
    {
        parent::__construct($query, $model, $collection, $resource, $resourceCollection, $defaultData,$searcher);
        $this->query = app(config('callmeaf-cart.model'))->query();
        $this->resource = config('callmeaf-cart.model_resource');
        $this->resourceCollection = config('callmeaf-cart.model_resource_collection');
        $this->defaultData = config('callmeaf-cart.default_values');
        $this->searcher = config('callmeaf-cart.searcher');
    }

    public function createItemsViaVariationsData(array $variationsData): Collection
    {
        /**
         * TODO: SET TYPE
         */
        $cartItemService = app(config('callmeaf-cart-items.service'));

    }

    public function discharge(?array $events = []): CartServiceInterface
    {
        $this->model->items()->delete();
        $this->eventsCaller($events);
        return $this;
    }
}
