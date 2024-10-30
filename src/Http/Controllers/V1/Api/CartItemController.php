<?php

namespace Callmeaf\Cart\Http\Controllers\V1\Api;

use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Cart\Events\CartItemDestroyed;
use Callmeaf\Cart\Events\CartItemForceDestroyed;
use Callmeaf\Cart\Events\CartItemRestored;
use Callmeaf\Cart\Events\CartItemStored;
use Callmeaf\Cart\Events\CartItemUpdated;
use Callmeaf\Cart\Events\CartItemTrashed;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemDestroyRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemForceDestroyRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemRestoreRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemStoreInFutureRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemStoreRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemUpdateRequest;
use Callmeaf\Cart\Http\Requests\V1\Api\CartItemTrashedIndexRequest;
use Callmeaf\Cart\Models\Cart;
use Callmeaf\Cart\Models\CartItem;
use Callmeaf\Cart\Services\V1\CartItemService;
use Callmeaf\Cart\Utilities\V1\Api\CartItem\CartItemResources;
use Callmeaf\User\Services\V1\UserService;
use Illuminate\Support\Facades\Log;

class CartItemController extends ApiController
{
    protected CartItemService $cartItemService;
    protected CartItemResources $cartItemResources;
    protected UserService $userService;
    public function __construct()
    {
        app(config('callmeaf-cart-items.middlewares.cart_item'))($this);
        $this->cartItemService = app(config('callmeaf-cart-items.service'));
        $this->cartItemResources = app(config('callmeaf-cart-items.resources.cart_item'));
        $this->userService = app(config('callmeaf-user.service'));
    }


    public function store(CartItemStoreRequest $request)
    {
        try {
            $resources = $this->cartItemResources->store();
            $cartItem = $this->cartItemService->addToUserCurrentCart(variationId: $request->get('variation_id'),qty: $request->get('qty'),events: [
                CartItemStored::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart_item' => $cartItem,
            ],__('callmeaf-base::v1.successful_created', [
                'title' => $cartItem->responseTitles(ResponseTitle::STORE),
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function storeInFuture(CartItemStoreInFutureRequest $request)
    {
        try {
            $resources = $this->cartItemResources->store();
            $cartItem = $this->cartItemService->addToUserFutureCart(variationId: $request->get('variation_id'),qty: $request->get('qty'),events: [
                CartItemStored::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart_item' => $cartItem,
            ],__('callmeaf-base::v1.successful_created', [
                'title' => $cartItem->responseTitles(ResponseTitle::STORE),
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function update(CartItemUpdateRequest $request,CartItem $cartItem)
    {
        try {
            $qty = $request->get('qty');
            if(!$qty) {
                return $this->http($request)->delete(
                    route(config('callmeaf-base.api.prefix_route_name') . 'cart_items.destroy',$cartItem->id),
                );
            }
            $resources = $this->cartItemResources->update();
            $cartItem = $this->cartItemService->setModel($cartItem)->updateUserCurrentCart(qty: $qty,events: [
                CartItemUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart_item' => $cartItem,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $cartItem->responseTitles(ResponseTitle::UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function destroy(CartItemDestroyRequest $request,CartItem $cartItem)
    {
        try {
            $resources = $this->cartItemResources->destroy();
            $cartItem = $this->cartItemService->setModel($cartItem)->delete(events: [
                CartItemDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart_item' => $cartItem,
            ],__('callmeaf-base::v1.successful_deleted', [
                'title' =>  $cartItem->responseTitles(ResponseTitle::DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }


    public function restore(CartItemRestoreRequest $request,string|int $id)
    {
        try {
            $resources = $this->cartItemResources->restore();
            $cartItem = $this->cartItemService->restore(id: $id,idColumn: $resources->idColumn(),events: [
                CartItemRestored::class
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart_item' => $cartItem,
            ],__('callmeaf-base::v1.successful_restored',[
                'title' =>  $cartItem->responseTitles(ResponseTitle::RESTORE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function trashed(CartItemTrashedIndexRequest $request)
    {
        try {
            $resources = $this->cartItemResources->trashed();
            $cartItems = $this->cartItemService->onlyTrashed()->all(
                relations: $resources->relations(),
                columns: $resources->columns(),
                filters: $request->validated(),
                events: [
                    CartItemTrashed::class,
                ],
            )->getCollection(asResourceCollection: true,asResponseData: true,attributes: $resources->attributes());
            return apiResponse([
                'carts' => $cartItems,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function forceDestroy(CartItemForceDestroyRequest $request,string|int $id)
    {
        try {
            $resources = $this->cartItemResources->forceDestroy();
            $cartItem = $this->cartItemService->forceDelete(id: $id,idColumn: $resources->idColumn(),columns: $resources->columns(),events: [
                CartItemForceDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'cart_item' => $cartItem,
            ],__('callmeaf-base::v1.successful_force_destroyed',[
                'title' =>  $cartItem->responseTitles(ResponseTitle::FORCE_DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

}
