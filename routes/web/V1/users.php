<?php

use App\Http\Controllers\API\V1\UserController;
use App\Http\Middleware\RestrictedMiddleware;
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
        // Forbidden access to banned users.
        ->middleware(RestrictedMiddleware::class)
        ->can('viewAny', User::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->middleware(RestrictedMiddleware::class)
        ->can('exportAny', User::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{user}', 'show')
        ->can('view', 'user')
        ->middleware(IncludeRelationMiddleware::class);

    Route::get('{user}/export', 'singleExport')
        ->middleware(RestrictedMiddleware::class)
        ->can('export', 'user');

    Route::post('', 'store')
        ->middleware(RestrictedMiddleware::class)
        ->can('create', User::class);

    Route::put('{user}', 'update')
        ->middleware(RestrictedMiddleware::class)
        ->can('update', 'user');

    Route::patch('{user}', 'update')
        ->middleware(RestrictedMiddleware::class)
        ->can('update', 'user');

    Route::delete('{user}', 'destroy')
        ->middleware(RestrictedMiddleware::class)
        ->can('delete', 'user');

    // Picture routes
    Route::prefix('{user}/picture')
        ->middleware(RestrictedMiddleware::class)
        ->group(function() {
        Route::post('', 'storePicture')
            ->can('update', 'user');

        Route::delete('', 'destroyPicture')
            ->can('update', 'user');
    });
});
