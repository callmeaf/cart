<?php

use \Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    Route::apiResource('carts',config('callmeaf-cart.controllers.carts'));
    Route::prefix('carts')->as('carts.')->controller(config('callmeaf-cart.controllers.carts'))->group(function() {
        Route::prefix('{cart}')->group(function() {
            Route::patch('/status','statusUpdate')->name('status_update');
            Route::patch('/restore','restore')->name('restore');
            Route::delete('/force','forceDestroy')->name('force_destroy');
            Route::patch('/image','imageUpdate')->name('image.update');
            Route::delete('/discharge','discharge')->name('discharge');
        });
        Route::get('/trashed/index','trashed')->name('trashed.index');
    });
});


Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    Route::apiResource('cart_items',config('callmeaf-cart-items.controllers.cart_items'));
    Route::prefix('cart_items')->as('cart_items.')->controller(config('callmeaf-cart-items.controllers.cart_items'))->group(function() {
        Route::post('future/add',[config('callmeaf-cart-items.controllers.cart_items'),'storeInFuture']);
        Route::prefix('{cart_item}')->group(function() {
            Route::patch('/status','statusUpdate')->name('status_update');
            Route::patch('/restore','restore')->name('restore');
            Route::delete('/force','forceDestroy')->name('force_destroy');
            Route::patch('/image','imageUpdate')->name('image.update');
        });
        Route::get('/trashed/index','trashed')->name('trashed.index');
    });
});
