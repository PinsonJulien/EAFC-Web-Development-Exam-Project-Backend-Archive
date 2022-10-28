<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\EducationLevelController;

Route::get('');

Route::prefix('education-levels')
    ->controller(EducationLevelController::class)
    ->group(function() {
        Route::get('', 'index');
    });
