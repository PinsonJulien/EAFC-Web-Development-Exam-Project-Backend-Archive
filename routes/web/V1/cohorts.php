<?php

use App\Http\Controllers\API\V1\CohortController;
use App\Http\Middleware\RestrictedMiddleware;
use App\Models\Cohort;
use App\Models\CohortMember;
use App\Models\Grade;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('cohorts')
    // Forbidden access to banned users.
    ->middleware(RestrictedMiddleware::class)
    ->controller(CohortController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', Cohort::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', Cohort::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{cohort}', 'show')
        ->can('view', 'cohort')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', Cohort::class);

    Route::put('{cohort}', 'update')
        ->can('update', 'cohort');

    Route::patch('{cohort}', 'update')
        ->can('update', 'cohort');

    Route::delete('{cohort}', 'destroy')
        ->can('delete', 'cohort');

    // CohortMembers
    Route::prefix('{cohort}/users')->group(function() {
        Route::get('', 'indexCohortMember')
            ->can('viewAny', CohortMember::class);

        Route::get('{user}', 'showCohortMember')
            ->can('view', CohortMember::class);

        Route::post('', 'storeCohortMember')
            ->can('create', CohortMember::class);

        Route::put('{user}', 'updateCohortMember')
            ->can('update', CohortMember::class);

        Route::patch('{user}', 'updateCohortMember')
            ->can('update', CohortMember::class);

        Route::delete('{user}', 'destroyCohortMember')
            ->can('delete', CohortMember::class);
    });

    // Courses
    Route::prefix('{cohort}/courses')->group(function () {
       Route::post('', 'storeCourse')
           ->can('create', Grade::class);
    });
});
