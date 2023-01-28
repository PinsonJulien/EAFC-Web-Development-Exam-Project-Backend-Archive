<?php

use App\Http\Controllers\API\V1\CourseController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('courses')
//    ->middleware('auth')
    ->controller(CourseController::class)
    ->group(function() {

   Route::get('', 'index')
        ->can('viewAny', Course::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

   Route::get('/export', 'export')
       ->can('viewAny', Course::class)
       ->middleware(FilterMiddleware::class)
       ->middleware(SortMiddleware::class);

   Route::get('{course}', 'show')
       ->can('view', 'course')
       ->middleware(IncludeRelationMiddleware::class);

   Route::post('', 'store')
       ->can('create', Course::class);

   Route::put('{course}', 'update')
       ->can('update', 'course');

   Route::patch('{course}', 'update')
       ->can('update', 'course');

   Route::delete('{course}', 'destroy')
       ->can('delete', 'course');
});
