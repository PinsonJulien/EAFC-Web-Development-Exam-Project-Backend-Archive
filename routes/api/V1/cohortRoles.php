<?php

use App\Http\Controllers\API\V1\CohortRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('cohortRoles')
    ->controller(CohortRoleController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{cohortRole}', 'show');

    Route::post('', 'store');

    Route::put('{cohortRole}', 'update');

    Route::patch('{cohortRole}', 'update');

    Route::delete('{cohortRole}', 'destroy');
});
