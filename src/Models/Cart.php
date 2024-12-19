<?php

namespace Callmeaf\Cart\Models;

use Callmeaf\Base\Contracts\HasEnum;
use Callmeaf\Base\Contracts\HasResponseTitles;
use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\HasType;
use Callmeaf\Cart\Enums\CartType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model implements HasResponseTitles,HasEnum
{
    use HasDate,HasType;
    protected $fillable = [
        'user_id',
        'type',
    ];

    protected $casts = [
        'type' => CartType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-user.model'));
    }

    public function items(): HasMany
    {
        return $this->hasMany(config('callmeaf-cart-items.model'));
    }


    public function responseTitles(ResponseTitle|string $key,string $default = ''): string
    {
        $user = $this->user;
        return [
            'store' => $user?->mobile ?? $default,
            'update' => $user?->mobile ?? $default,
            'discharge' => $user?->mobile ?? $default,
        ][$key instanceof ResponseTitle ? $key->value : $key];
    }

    public static function enumsLang(): array
    {
        return __('callmeaf-cart::enums');
    }
}
