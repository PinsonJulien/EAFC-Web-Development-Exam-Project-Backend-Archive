<?php

use App\Http\Controllers\API\V1\EducationLevelController;
use App\Models\EducationLevel;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('educationLevels')
    ->controller(EducationLevelController::class)
    ->group(function() {

    Route::get('', 'index')
        ->can('viewAny', EducationLevel::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('/export', 'export')
        ->can('exportAny', EducationLevel::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class);

    Route::get('{educationLevel}', 'show')
        ->can('view', 'educationLevel')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store')
        ->can('create', EducationLevel::class);

    Route::put('{educationLevel}', 'update')
        ->can('update', 'educationLevel');

    Route::patch('{educationLevel}', 'update')
        ->can('update', 'educationLevel');

    Route::delete('{educationLevel}', 'destroy')
        ->can('delete', 'educationLevel');
});
