<?php

use App\Http\Controllers\API\V1\GradeController;
use App\Http\Middleware\RestrictedMiddleware;
use App\Models\Grade;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('grades')
    // Forbidden access to banned users.
    ->middleware(RestrictedMiddleware::class)
    ->controller(GradeController::class)
    ->group(function() {

        Route::get('', 'index')
            ->can('viewAny', Grade::class)
            ->middleware(FilterMiddleware::class)
            ->middleware(SortMiddleware::class)
            ->middleware(PaginationMiddleware::class);

        Route::get('/export', 'export')
            ->can('exportAny', Grade::class)
            ->middleware(FilterMiddleware::class)
            ->middleware(SortMiddleware::class);

        Route::get('{grade}', 'show')
            ->can('view', 'grade');

        Route::post('', 'store')
            ->can('create', Grade::class);

        Route::put('{grade}', 'update')
            ->can('update', 'grade');

        Route::patch('{grade}', 'update')
            ->can('update', 'grade');

        Route::delete('{grade}', 'destroy')
            ->can('delete', 'grade');
    });
