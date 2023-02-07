<?php

use App\Http\Controllers\API\V1\StatusController;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\RestrictedMiddleware;
use App\Models\Status;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('statuses')
    // Forbidden access to banned users.
    ->middleware(RestrictedMiddleware::class)
    ->controller(StatusController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', Status::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', Status::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{status}', 'show')
        ->can('view', 'status')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', Status::class);

    Route::put('{status}', 'update')
        ->can('update', 'status');

    Route::patch('{status}', 'update')
        ->can('update', 'status');

    Route::delete('{status}', 'destroy')
        ->can('delete', 'status');
});
