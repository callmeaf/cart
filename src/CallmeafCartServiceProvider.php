<?php

namespace Callmeaf\Cart;

use Callmeaf\Base\CallmeafServiceProvider;
use Callmeaf\Base\Contracts\ServiceProvider\HasConfig;
use Callmeaf\Base\Contracts\ServiceProvider\HasEvent;
use Callmeaf\Base\Contracts\ServiceProvider\HasLang;
use Callmeaf\Base\Contracts\ServiceProvider\HasMigration;
use Callmeaf\Base\Contracts\ServiceProvider\HasRepo;
use Callmeaf\Base\Contracts\ServiceProvider\HasRoute;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;

class CallmeafCartServiceProvider extends CallmeafServiceProvider implements HasRepo, HasEvent, HasRoute, HasMigration, HasConfig, HasLang
{
    protected function serviceKey(): string
    {
        return 'cart';
    }

    public function repo(): string
    {
        return CartRepoInterface::class;
    }
}
