<?php

namespace Callmeaf\Cart\App\Models;

use Callmeaf\Base\App\Models\BaseModel;
use Callmeaf\Base\App\Traits\Model\HasDate;
use Callmeaf\Base\App\Traits\Model\HasSearch;
use Callmeaf\Base\App\Traits\Model\HasType;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Callmeaf\CartItem\App\Repo\Contracts\CartItemRepoInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends BaseModel
{
    // use SoftDeletes;
    use HasType,HasDate,HasSearch;

    protected $fillable = [
        'user_identifier',
        'type'
    ];

    public static function configKey(): string
    {
        return 'callmeaf-cart';
    }

    protected function casts(): array
    {
        return [
            ...(self::config()['enums'] ?? []),
        ];
    }

    public function items(): HasMany
    {
        /**
         * @var CartItemRepoInterface $cartItemRepo
         */
        $cartItemRepo = app(CartItemRepoInterface::class);
        return $this->hasMany($cartItemRepo->getModel()::class);
    }

    public function variants(bool $withProduct = false)
    {
        $relation = ['variant'];
        if($withProduct) {
            $relation = ['variant.product'];
        }

        $data = [];
        foreach ($this->items()->with($relation)->get() as $item) {
            $variant = $item->variant;
            $variant->qty = $item->qty;
            $data[] = $variant;
        }

        return $data;
    }

    public function searchParams(): array
    {
        if(isAdminRequest()) {
            return [
                [
                    'user_identifier' => 'user_identifier',
                ],
                [
                    'type' => 'type',
                ]
            ];
        }
        return [
            [
                //
            ],
            [
                'type' => 'type',
            ]
        ];
    }
}
