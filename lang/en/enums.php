<?php

use Callmeaf\Cart\Enums\CartType;

return [
    CartType::class => [
        CartType::CURRENT->name => 'Current',
        CartType::FUTURE->name => 'Future',
    ],
];
