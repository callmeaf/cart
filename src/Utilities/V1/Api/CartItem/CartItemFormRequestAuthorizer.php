<?php

namespace Callmeaf\Cart\Utilities\V1\Api\CartItem;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;
use Callmeaf\Permission\Enums\PermissionName;

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
        return userCan(PermissionName::CART_UPDATE);
    }

    public function destroy(): bool
    {
        return userCan(PermissionName::CART_DESTROY);
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
