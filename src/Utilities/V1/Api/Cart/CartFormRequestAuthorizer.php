<?php

namespace Callmeaf\Cart\Utilities\V1\Api\Cart;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;
use Callmeaf\Permission\Enums\PermissionName;

class CartFormRequestAuthorizer extends FormRequestAuthorizer
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

    public function discharge(): bool
    {
        return userCan(PermissionName::CART_UPDATE);
    }
}
