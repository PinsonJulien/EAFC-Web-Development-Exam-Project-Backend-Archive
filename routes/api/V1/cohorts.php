<?php

use App\Http\Controllers\API\V1\CohortController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;


Route::prefix('cohorts')
    ->controller(CohortController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('{cohort}', 'show')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store');
});
