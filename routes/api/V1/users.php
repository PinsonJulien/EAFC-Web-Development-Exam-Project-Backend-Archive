<?php

use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class);

    Route::get('{user}', 'show')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store');
});
