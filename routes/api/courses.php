<?php

use \App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('');

Route::prefix('courses')
    ->controller(CourseController::class)
    ->group(function() {
   Route::get('', 'index');
});
