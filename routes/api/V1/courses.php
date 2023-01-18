<?php

use App\Http\Controllers\API\V1\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;

Route::prefix('courses')
    ->controller(CourseController::class)
    ->group(function() {
   Route::get('', 'index')
       ->middleware(SortMiddleware::class)
       ->middleware(IncludeRelationMiddleware::class);
   Route::get('{course}', 'show');
   Route::post('', 'store');
   Route::delete('{course}', 'destroy');
});
