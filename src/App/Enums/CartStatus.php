<?php

namespace Callmeaf\Cart\App\Enums;


use Callmeaf\Base\App\Enums\BaseStatus;

enum CartStatus: string
{
    case ACTIVE = BaseStatus::ACTIVE->value;
    case INACTIVE = BaseStatus::INACTIVE->value;
    case PENDING = BaseStatus::PENDING->value;
}
