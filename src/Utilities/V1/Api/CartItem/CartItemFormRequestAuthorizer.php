<?php

namespace Callmeaf\Cart\Utilities\V1\Api\CartItem;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;
use Callmeaf\Permission\Enums\PermissionName;
use Illuminate\Support\Facades\Log;

class CartItemFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function index(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return userCan(PermissionName::CART_STORE);
    }

    public function store(): bool
    {
        return userCan(PermissionName::CART_STORE);
    }

    public function storeInFuture(): bool
    {
        return userCan(PermissionName::CART_STORE);
    }


    public function show(): bool
    {
        return userCan(PermissionName::CART_SHOW);
    }

    public function edit(): bool
    {
        return userCan(PermissionName::CART_UPDATE);
    }

    public function update(): bool
    {
        $result = userCan(PermissionName::CART_UPDATE);
        $user = $this->request->user();
        if($user->isSuperAdminOrAdmin()) {
            return $result;
        }
        return $result && strval($user?->id) === strval($this->request->get('cart_item')->cart->user_id);
    }

    public function destroy(): bool
    {
        $result = userCan(PermissionName::CART_DESTROY);
        $user = $this->request->user();
        if($user->isSuperAdminOrAdmin()) {
            return $result;
        }
        return $result && strval($user?->id) === strval($this->request->get('cart_item')->cart->user_id);
    }

    public function trashed(): bool
    {
        return userCan(PermissionName::CART_TRASHED);
    }

    public function restore(): bool
    {
        return userCan(PermissionName::CART_RESTORE);
    }

    public function forceDestroy(): bool
    {
        return userCan(PermissionName::CART_FORCE_DESTROY);
    }

}
