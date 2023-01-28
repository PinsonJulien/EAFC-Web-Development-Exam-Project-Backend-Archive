<?php

use App\Http\Controllers\API\V1\CourseController;
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
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(IncludeRelationMiddleware::class)
        ->middleware(PaginationMiddleware::class);

   Route::get('/export', 'export')
       ->middleware(FilterMiddleware::class)
       ->middleware(SortMiddleware::class);

   Route::get('{course}', 'show')
       ->middleware(IncludeRelationMiddleware::class);

   Route::post('', 'store')
       ->middleware('can:create,course');

   Route::put('{course}', 'update')
       ->middleware('can:update,course');

   Route::patch('{course}', 'update');

   Route::delete('{course}', 'destroy');
});
