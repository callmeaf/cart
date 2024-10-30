<?php

namespace Callmeaf\Cart;

use Callmeaf\Cart\Commands\RemoveUselessCartItemsCommand;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CallmeafCartServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const CONFIGS_KEY = 'callmeaf-cart';
    private const CONFIGS_GROUP = 'callmeaf-cart-config';
    private const VARIATION_TYPE_CONFIGS_KEY = 'callmeaf-cart-items';
    private const VARIATION_TYPE_CONFIGS_GROUP = 'callmeaf-cart-items-config';
    private const ROUTES_DIR = __DIR__ . '/../routes';
    private const DATABASE_DIR = __DIR__ . '/../database';
    private const DATABASE_GROUPS = 'callmeaf-cart-migrations';
    private const RESOURCES_DIR = __DIR__ . '/../resources';
    private const VIEWS_NAMESPACE = 'callmeaf-cart';
    private const VIEWS_GROUP = 'callmeaf-cart-views';
    private const LANG_DIR = __DIR__ . '/../lang';
    private const LANG_NAMESPACE = 'callmeaf-cart';
    private const LANG_GROUP = 'callmeaf-cart-lang';
    public function boot()
    {
        $this->registerConfig();
        $this->registerRoute();
        $this->registerMigration();
        $this->registerEvents();
        $this->registerViews();
        $this->registerLang();
        $this->registerSeeders();
        $this->registerCommands();
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-cart.php',self::CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-cart.php' => config_path('callmeaf-cart.php'),
        ],self::CONFIGS_GROUP);

        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-cart-items.php',self::VARIATION_TYPE_CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-cart-items.php' => config_path('callmeaf-cart-items.php'),
        ],self::VARIATION_TYPE_CONFIGS_GROUP);
    }

    private function registerRoute(): void
    {
        $this->loadRoutesFrom(self::ROUTES_DIR . '/v1/api.php');
    }

    private function registerMigration(): void
    {
        $this->loadMigrationsFrom(self::DATABASE_DIR . '/migrations');
        $this->publishes([
            self::DATABASE_DIR . '/migrations' => database_path('migrations'),
        ],self::DATABASE_GROUPS);
    }

    private function registerEvents(): void
    {
        foreach (config('callmeaf-cart.events') as $event => $listeners) {
            Event::listen($event,function($event) use ($listeners) {
                foreach($listeners as $listener) {
                    app($listener)->handle($event);
                }
            });
        }

        foreach (config('callmeaf-cart-items.events') as $event => $listeners) {
            Event::listen($event,function($event) use ($listeners) {
                foreach($listeners as $listener) {
                    app($listener)->handle($event);
                }
            });
        }
    }

    private function registerViews(): void
    {
        $this->loadViewsFrom(self::RESOURCES_DIR . '/views',self::VIEWS_NAMESPACE);
        $this->publishes([
            self::RESOURCES_DIR . '/views' => resource_path('views/vendor/callmeaf-cart'),
        ],self::VIEWS_GROUP);

    }

    private function registerLang(): void
    {
        $langPathFromVendor = lang_path('vendor/callmeaf/cart');
        if(is_dir($langPathFromVendor)) {
            $this->loadTranslationsFrom($langPathFromVendor,self::LANG_NAMESPACE);
        } else {
            $this->loadTranslationsFrom(self::LANG_DIR,self::LANG_NAMESPACE);
        }
        $this->publishes([
            self::LANG_DIR => $langPathFromVendor,
        ],self::LANG_GROUP);
    }

    private function registerSeeders(): void
    {
        $this->callAfterResolving(DatabaseSeeder::class,function ($seeder) {
            $seeder->callOnce(config('callmeaf-cart.seeders'));
        });
    }

    private function registerCommands(): void
    {
        $this->app->booted(function() {
            $this->commands([
                RemoveUselessCartItemsCommand::class,
            ]);
        });
    }
}
