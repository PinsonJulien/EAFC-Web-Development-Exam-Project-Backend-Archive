<?php

use App\Http\Controllers\API\V1\CohortRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;

Route::prefix('cohortRoles')
    ->controller(CohortRoleController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{cohortRole}', 'show');

    Route::post('', 'store');
    Route::delete('{cohortRole}', 'destroy');
});
