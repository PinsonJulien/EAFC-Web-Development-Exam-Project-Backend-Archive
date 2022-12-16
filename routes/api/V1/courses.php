<?php

use App\Http\Controllers\API\V1\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')
    ->controller(CourseController::class)
    ->group(function() {
   Route::get('', 'index');
   Route::get('{course}', 'show');
   Route::post('', 'store');
});
