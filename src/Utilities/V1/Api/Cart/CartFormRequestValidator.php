<?php

namespace Callmeaf\Cart\Utilities\V1\Api\Cart;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class CartFormRequestValidator extends FormRequestValidator
{
    public function index(): array
    {
        return [

        ];
    }

    public function store(): array
    {
        return [
            'user_id' => true,
            'type' => true,
            'variation_ids' => false,
            'variation_ids.*.id' => true,
            'variation_ids.*.qty' => false,
        ];
    }

    public function show(): array
    {
        return [];
    }

    public function update(): array
    {
        return [
            'user_id' => false,
            'type' => true,
        ];
    }

    public function discharge(): array
    {
        return [];
    }
}
