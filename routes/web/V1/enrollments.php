<?php

use App\Http\Controllers\API\V1\EnrollmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('enrollments')
    ->controller(EnrollmentController::class)
    ->group(function() {

   Route::get('', 'index')
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(PaginationMiddleware::class);

   Route::get('/export', 'export')
       ->middleware(FilterMiddleware::class)
       ->middleware(SortMiddleware::class);

   Route::get('{enrollment}', 'show');

   Route::post('', 'store');

   Route::put('{enrollment}', 'update');

   Route::patch('{enrollment}', 'update');

   Route::delete('{enrollment}', 'destroy');
});
