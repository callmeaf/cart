<?php

namespace Callmeaf\Cart\Http\Controllers\V1\Api;

use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Cart\Events\CartDestroyed;
use Callmeaf\Cart\Events\CartIndexed;
use Callmeaf\Cart\Events\CartShowed;
use Callmeaf\Cart\Events\CartStored;
use Callmeaf\Cart\Events\CartUpdated;
use Callmeaf\Cart\Http\Requests\V1\Api\CartDestroyRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartIndexRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartShowRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartStoreRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartUpdateRequest;
use Callmeaf\Cart\Models\Cart;
use Callmeaf\Cart\Services\V1\CartService;
use Callmeaf\Cart\Utilities\V1\Api\Cart\CartResources;

class CartController extends ApiController
{
    protected CartService $cartService;
    protected CartResources $cartResources;
    public function __construct()
    {
        app(config('callmeaf-cart.middlewares.cart'))($this);
        $this->cartService = app(config('callmeaf-cart.service'));
        $this->cartResources = app(config('callmeaf-cart.resources.cart'));
    }

    public function index(CartIndexRequest $request)
    {
        try {
            $resources = $this->cartResources->index();
            $carts = $this->cartService->all(
                relations: $resources->relations(),
                columns: $resources->columns(),
                filters: $request->validated(),
                events: [
                    CartIndexed::class,
                ],
            )->getCollection(asResourceCollection: true,asResponseData: true,attributes: $resources->attributes());
            return apiResponse([
                'carts' => $carts,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function store(CartStoreRequest $request)
    {
        try {
            $resources = $this->cartResources->store();
            $cart = $this->cartService->create(data: $request->validated(),events: [
                CartStored::class
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart' => $cart,
            ],__('callmeaf-base::v1.successful_created', [
                'title' => $cart->responseTitles(ResponseTitle::STORE),
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function show(CartShowRequest $request,Cart $cart)
    {
        try {
            $resources = $this->cartResources->show();
            $cart = $this->cartService->setModel($cart)->getModel(
                asResource: true,
                attributes: $resources->attributes(),
                relations: $resources->relations(),
                events: [
                    CartShowed::class,
                ],
            );
            return apiResponse([
                'cart' => $cart,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function update(CartUpdateRequest $request,Cart $cart)
    {
        try {
            $resources = $this->cartResources->update();
            $cart = $this->cartService->setModel($cart)->update(data: $request->validated(),events: [
                CartUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart' => $cart,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $cart->responseTitles(ResponseTitle::UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function destroy(CartDestroyRequest $request,Cart $cart)
    {
        try {
            $resources = $this->cartResources->destroy();
            $cart = $this->cartService->setModel($cart)->delete(events: [
                CartDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart' => $cart,
            ],__('callmeaf-base::v1.successful_deleted', [
                'title' =>  $cart->responseTitles(ResponseTitle::DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
