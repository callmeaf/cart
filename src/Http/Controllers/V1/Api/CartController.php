<?php

namespace Callmeaf\Cart\Http\Controllers\V1\Api;

use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Cart\Events\CartDestroyed;
use Callmeaf\Cart\Events\CartDischarged;
use Callmeaf\Cart\Events\CartForceDestroyed;
use Callmeaf\Cart\Events\CartIndexed;
use Callmeaf\Cart\Events\CartRestored;
use Callmeaf\Cart\Events\CartShowed;
use Callmeaf\Cart\Events\CartStored;
use Callmeaf\Cart\Events\CartTrashed;
use Callmeaf\Cart\Events\CartUpdated;
use Callmeaf\Cart\Http\Requests\V1\Api\CartDestroyRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartDischargeRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartForceDestroyRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartIndexRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartRestoreRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartShowRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartStoreRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartTrashedIndexRequest;
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
        $this->cartService = app(config('callmeaf-cart.service'));
        $this->cartResources = app(config('callmeaf-cart.resources.cart'));
    }

    public static function middleware(): array
    {
        return app(config('callmeaf-cart.middlewares.cart'))();
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

    public function show(CartShowRequest $request,string|int $id)
    {
        try {
            if($id === config('callmeaf-base.route_model_binding_key_for_authenticate_user')) {
                $cart = authUser($request)->currentCart;
            } else {
                $cart = $this->cartService->freshQuery()->where(column: 'id',valueOrOperation: $id)->first()->getModel();
            }
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

    public function discharge(CartDischargeRequest $request,Cart $cart)
    {
        try {
            $resources = $this->cartResources->discharge();
            $cart = $this->cartService->setModel($cart)->discharge(
                events: [
                    CartDischarged::class
                ],
            )->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
             return apiResponse([
                 'cart' => $cart,
             ],__('callmeaf-base::v1.successful_updated',[
                 'title' => $cart->responseTitles('discharge'),
             ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

}
