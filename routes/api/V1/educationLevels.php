<?php

use App\Http\Controllers\API\V1\EducationLevelController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;

Route::prefix('educationLevels')
    ->controller(EducationLevelController::class)
    ->group(function() {

    Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class);

    Route::get('{educationLevel}', 'show')
        ->middleware(IncludeRelationMiddleware::class);

    Route::post('', 'store');
});
