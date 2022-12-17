<?php

use App\Http\Controllers\API\V1\EducationLevelController;
use Illuminate\Support\Facades\Route;

Route::prefix('educationLevels')
    ->controller(EducationLevelController::class)
    ->group(function() {
    Route::get('', 'index');
    Route::get('{educationLevel}', 'show');
    Route::post('', 'store');
});
