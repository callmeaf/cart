<?php

namespace Callmeaf\Cart\App\Traits;

use Callmeaf\Base\App\Models\BaseModel;
use Callmeaf\Cart\App\Enums\CartType;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasCart
{
    public static function bootHasCart(): void
    {
        static::created(function(Model|BaseModel $model) {
            /**
             * @var HasCart $model
             */

            $carts = [];

            foreach ($model->availableCarts() as $availableCartType) {
                $carts[] = [
                    'type' => $availableCartType
                ];
            }

            if(!empty($carts)) {
                $model->carts()->createMany($carts);
            }
        });
    }
    public function carts(): HasMany
    {
        /**
         * @var CartRepoInterface $cartRepo
         */
        $cartRepo = app(CartRepoInterface::class);
        return $this->hasMany($cartRepo->getModel()::class,'user_identifier',$this->getRouteKeyName());
    }

    public function currentCart(): HasOne
    {
        return $this->carts()->ofType(CartType::CURRENT->value)->one();
    }

    public function nextCart(): HasOne
    {
        return $this->carts()->ofType(CartType::NEXT->value)->one();
    }

    public function availableCarts(): array
    {
        return [
            CartType::CURRENT->value,
            CartType::NEXT->value,
        ];
    }
}
