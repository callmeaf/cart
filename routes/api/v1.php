<?php

use Illuminate\Support\Facades\Route;

[
    $controllers,
    $prefix,
    $as,
    $middleware,
] = Base::getRouteConfigFromRepo(repo: \Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface::class);

Route::apiResource($prefix, $controllers['cart'])->only([
    'index',
    'store',
    'update',
])->middleware($middleware);
// Route::prefix($prefix)->as($as)->middleware($middleware)->controller($controllers['cart'])->group(function () {
    // Route::get('trashed/list', 'trashed');
    // Route::prefix('{cart}')->group(function () {
        // Route::patch('/status', 'statusUpdate');
        // Route::patch('/type', 'typeUpdate');
        // Route::patch('/restore', 'restore');
        // Route::delete('/force', 'forceDestroy');
    // });
// });
