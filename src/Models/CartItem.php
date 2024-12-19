<?php

namespace Callmeaf\Cart\Models;

use Callmeaf\Base\Contracts\HasEnum;
use Callmeaf\Base\Contracts\HasResponseTitles;
use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\HasType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model implements HasResponseTitles,HasEnum
{
    use HasDate,HasType,SoftDeletes;
    protected $fillable = [
        'cart_id',
        'variation_id',
        'qty',
    ];

    protected $casts = [
        'qty' => 'integer'
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-cart.model'));
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-variation.model'));
    }


    public function responseTitles(ResponseTitle|string $key,string $default = ''): string
    {
        $user = $this->cart->user;
        return [
            'store' => $user?->mobile ?? $default,
            'update' => $user?->mobile ?? $default,
            'status_update' => $user?->mobile ?? $default,
            'destroy' => $user?->mobile ?? $default,
            'restore' => $user?->mobile ?? $default,
            'force_destroy' => $user?->mobile ?? $default,
        ][$key instanceof ResponseTitle ? $key->value : $key];
    }

    public static function enumsLang(): array
    {
        return __('callmeaf-cart::enums');
    }
}
