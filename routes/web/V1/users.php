<?php

use App\Http\Controllers\API\V1\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', User::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', User::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{user}', 'show')
        ->can('view', 'user')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', User::class);

    Route::put('{user}', 'update')
        ->can('update', 'user');

    Route::patch('{user}', 'update')
        ->can('update', 'user');

    Route::delete('{user}', 'destroy')
        ->can('delete', 'user');

    // Picture routes
    Route::prefix('{user}/picture')->group(function() {
        Route::post('', 'storePicture')
            ->can('update', 'user');

        Route::delete('', 'destroyPicture')
            ->can('update', 'user');
    });
});
