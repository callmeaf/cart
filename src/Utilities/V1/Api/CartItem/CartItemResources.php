<?php

namespace Callmeaf\Cart\Utilities\V1\Api\CartItem;

use Callmeaf\Base\Utilities\V1\Resources;

class CartItemResources extends Resources
{
    public function index(): self
    {
        $this->data = [
            'relations' => [
                'cart',
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
                'variation_id',
                'type',
                'type_text',
                'qty',
                'created_at_text',
                'updated_at_text',
                'cart',
                '!cart' => [
                    'id',
                ],
            ],
        ];
        return $this;
    }

    public function store(): self
    {
        $this->data = [
            'relations' => [
                'cart'
            ],
            'attributes' => [
                'id',
                'variation_id',
                'type',
                'type_text',
                'qty',
                'created_at_text',
                'updated_at_text',
                'cart',
                '!cart' => [
                    'id',
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
                    'variation_id',
                    'qty',
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

    public function destroy(): self
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

    public function restore(): Resources
    {
        $this->data = [
            'id_column' => 'id',
            'columns' => [
                'id',
                'type',
                'status',
                'title',
                'slug',
                'first_name',
                'last_name',
                'national_code',
                'published_at',
                'expired_at',
                'created_at',
                'updated_at',
            ],
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

    public function trashed(): Resources
    {
        $this->data = [
            'relations' => [],
            'columns' => [
                'id',
                'type',
                'status',
                'title',
                'slug',
                'published_at',
                'expired_at',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'slug',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
                'deleted_at',
                'deleted_at_text',
            ],
        ];
        return $this;
    }

    public function forceDestroy(): Resources
    {
        $this->data = [
            'id_column' => 'id',
            'columns' => [
                'id',
                'title',
            ],
            'relations' => [],
            'attributes' => [
                'id',
            ],
        ];
        return $this;
    }

    public function imageUpdate(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'slug',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
                'image',
                '!image' => [
                    'id',
                    'url',
                    'name',
                    'file_name',
                    'collection_name',
                    'mime_type',
                    'disk',
                    'size',
                ],
            ],
        ];
        return $this;
    }
}
