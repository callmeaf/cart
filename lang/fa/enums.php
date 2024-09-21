<?php

use Callmeaf\Cart\Enums\CartType;

return [
    CartType::class => [
        CartType::CURRENT->name => 'فعلی',
        CartType::FUTURE->name => 'بعدی',
    ],
];
