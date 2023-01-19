<?php

use App\Http\Controllers\API\V1\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;

Route::prefix('courses')
    ->controller(CourseController::class)
    ->group(function() {

   Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class);

   Route::get('{course}', 'show')
       ->middleware(IncludeRelationMiddleware::class);

   Route::post('', 'store');
   Route::delete('{course}', 'destroy');
});
