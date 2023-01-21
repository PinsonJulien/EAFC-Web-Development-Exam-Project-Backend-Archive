<?php

use App\Http\Controllers\API\V1\CohortRoleController;
use App\Http\Middleware\IncludeRelationMiddleware;
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
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{cohortRole}', 'show')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store');

    Route::put('{cohortRole}', 'update');

    Route::patch('{cohortRole}', 'update');

    Route::delete('{cohortRole}', 'destroy');
});
