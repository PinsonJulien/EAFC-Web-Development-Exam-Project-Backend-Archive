<?php

use App\Http\Controllers\API\V1\StatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('statuses')
    ->controller(StatusController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('{status}', 'show');

    Route::post('', 'store');

    Route::put('{status}', 'update');

    Route::patch('{status}', 'update');

    Route::delete('{status}', 'destroy');
});
