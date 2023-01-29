<?php

use App\Http\Controllers\API\V1\CohortRoleController;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Models\CohortRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('cohortRoles')
    ->controller(CohortRoleController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', CohortRole::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', CohortRole::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{cohortRole}', 'show')
        ->can('view', 'cohortRole')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', CohortRole::class);

    Route::put('{cohortRole}', 'update')
        ->can('update', 'cohortRole');

    Route::patch('{cohortRole}', 'update')
        ->can('update', 'cohortRole');

    Route::delete('{cohortRole}', 'destroy')
        ->can('delete', 'cohortRole');
});
