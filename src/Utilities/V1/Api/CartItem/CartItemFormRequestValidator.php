<?php

namespace Callmeaf\Cart\Utilities\V1\Api\CartItem;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class CartItemFormRequestValidator extends FormRequestValidator
{
    public function index(): array
    {
        return [

        ];
    }

    public function store(): array
    {
        return [
            'user_id' => false,
            'variation_id' => true,
            'qty' => false,
        ];
    }

    public function show(): array
    {
        return [];
    }

    public function update(): array
    {
        return [
            'qty' => true,
        ];
    }

    public function destroy(): array
    {
        return [];
    }

    public function restore(): array
    {
        return [];
    }

    public function trashed(): array
    {
        return [

        ];
    }

    public function forceDestroy(): array
    {
        return [];
    }
}
