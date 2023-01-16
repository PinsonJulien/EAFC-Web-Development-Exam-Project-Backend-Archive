<?php

use App\Http\Controllers\API\V1\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;

Route::prefix('courses')
    ->controller(CourseController::class)
    ->group(function() {
   Route::get('', 'index')->middleware(SortMiddleware::class);
   Route::get('{course}', 'show');
   Route::post('', 'store');
   Route::delete('{course}', 'destroy');
});
