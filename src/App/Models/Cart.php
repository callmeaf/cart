<?php

namespace Callmeaf\Cart\App\Models;

use Callmeaf\Base\App\Models\BaseModel;
use Callmeaf\Base\App\Traits\Model\HasDate;
use Callmeaf\Base\App\Traits\Model\HasSearch;
use Callmeaf\Base\App\Traits\Model\HasType;
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
