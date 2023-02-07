<?php

use App\Http\Controllers\API\V1\FormationController;
use App\Http\Middleware\RestrictedMiddleware;
use App\Models\Formation;
use App\Models\FormationCourse;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('formations')
    // Forbidden access to banned users.
    ->middleware(RestrictedMiddleware::class)
    ->controller(FormationController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', Formation::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', Formation::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{formation}', 'show')
        ->can('view', 'formation')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', Formation::class);

    Route::put('{formation}', 'update')
        ->can('update', 'formation');

    Route::patch('{formation}', 'update')
        ->can('update', 'formation');

    Route::delete('{formation}', 'destroy')
        ->can('delete', 'formation');

    // Course related routes
    Route::prefix('{formation}/courses')->group(function() {
        Route::post('', 'storeCourse')
            ->can('create', FormationCourse::class);

        Route::delete('{course}', 'destroyCourse')
            ->can('delete', FormationCourse::class);
    });
});
