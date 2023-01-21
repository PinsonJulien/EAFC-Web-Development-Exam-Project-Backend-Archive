<?php

use App\Http\Controllers\API\V1\EducationLevelController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('educationLevels')
    ->controller(EducationLevelController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

    Route::get('{educationLevel}', 'show')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store');

    Route::put('{educationLevel}', 'update');

    Route::patch('{educationLevel}', 'update');

    Route::delete('{educationLevel}', 'destroy');
});
