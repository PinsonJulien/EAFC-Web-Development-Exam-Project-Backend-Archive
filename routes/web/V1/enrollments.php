<?php

use App\Http\Controllers\API\V1\EnrollmentController;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SortMiddleware;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\PaginationMiddleware;

Route::prefix('enrollments')
    ->controller(EnrollmentController::class)
    ->group(function() {

   Route::get('', 'index')
        ->can('viewAny', Enrollment::class)
        ->middleware(FilterMiddleware::class)
        ->middleware(SortMiddleware::class)
        ->middleware(PaginationMiddleware::class);

   Route::get('/export', 'export')
       ->can('exportAny', Enrollment::class)
       ->middleware(FilterMiddleware::class)
       ->middleware(SortMiddleware::class);

   Route::get('{enrollment}', 'show')
       ->can('view', 'enrollment');

   Route::post('', 'store')
       ->can('create', Enrollment::class);

   Route::put('{enrollment}', 'update')
       ->can('update', 'enrollment');

   Route::patch('{enrollment}', 'update')
       ->can('update', 'enrollment');

   Route::delete('{enrollment}', 'destroy')
       ->can('delete', 'enrollment');
});
