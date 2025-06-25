<?php

use Callmeaf\Cart\App\Enums\CartStatus;
use Callmeaf\Cart\App\Enums\CartType;

return [
    CartStatus::class => [
        CartStatus::ACTIVE->name => 'Active',
        CartStatus::INACTIVE->name => 'InActive',
        CartStatus::PENDING->name => 'Pending',
    ],
    CartType::class => [
        CartType::CURRENT->name => 'Current',
        CartType::NEXT->name => 'Next',
    ],
];
