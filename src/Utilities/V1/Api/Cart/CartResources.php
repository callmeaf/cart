<?php

namespace Callmeaf\Cart\Utilities\V1\Api\Cart;

use Callmeaf\Base\Utilities\V1\Resources;

class CartResources extends Resources
{
    public function index(): self
    {
        $this->data = [
            'relations' => [
                'user',
            ],
            'columns' => [
                'id',
                'user_id',
                'type',
                'created_at',
                'updated_at',
            ],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'full_name',
                ],
            ],
        ];
        return $this;
    }

    public function store(): self
    {
        $this->data = [
            'relations' => [
                'user'
            ],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'full_name',
                ],
            ],
        ];
        return $this;
    }

    public function show(): self
    {
        $this->data = [
            'relations' => [
                'user',
                'items',
            ],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'full_name',
                ],
                'items',
                '!items' => [
                    'id',
                    'qty',
                    'variation',
                    '!variation' => [
                        'id',
                        'title',
                        'price',
                        'discount_price',
                    ],
                ],
            ]
        ];
        return $this;
    }

    public function update(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'full_name',
                ],
            ],
        ];
        return $this;
    }

    public function discharge(): self
    {
        $this->data = [
            'relations' => [
                'user',
                'items',
            ],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'full_name',
                ],
                'items',
                '!items' => [
                    'id',
                    'qty',
                    'variation',
                    '!variation' => [
                        'id',
                        'title',
                        'price',
                        'discount_price',
                    ],
                ],
            ]
        ];
        return $this;
    }
}
