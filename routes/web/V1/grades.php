<?php

use App\Http\Controllers\API\V1\GradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('grades')
    ->controller(GradeController::class)
    ->group(function() {

        Route::get('', 'index')
            ->middleware(FilterMiddleware::class)
            ->middleware(SortMiddleware::class)
            ->middleware(PaginationMiddleware::class);

        Route::get('/export', 'export')
            ->middleware(FilterMiddleware::class)
            ->middleware(SortMiddleware::class);

        Route::get('{grade}', 'show');

        Route::post('', 'store');

        Route::put('{grade}', 'update');

        Route::patch('{grade}', 'update');

        Route::delete('{grade}', 'destroy');
    });
