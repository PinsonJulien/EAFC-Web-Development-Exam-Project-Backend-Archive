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

    Route::get('/export', 'export')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{cohort}', 'show')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store');

    Route::put('{cohort}', 'update');

    Route::patch('{cohort}', 'update');

    Route::delete('{cohort}', 'destroy');

    // CohortMembers
    Route::prefix('{cohort}/users')->group(function() {
        Route::get('', 'indexCohortMember');
        Route::get('{user}', 'showCohortMember');
        Route::post('', 'storeCohortMember');
        Route::put('{user}', 'updateCohortMember');
        Route::patch('{user}', 'updateCohortMember');
        Route::delete('{user}', 'destroyCohortMember');
    });

    // Courses
    Route::prefix('{cohort}/courses')->group(function () {
       Route::post('{course}', 'storeCourse');
    });
});
