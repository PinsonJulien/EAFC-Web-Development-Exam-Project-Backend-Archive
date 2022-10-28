<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FormationController;

Route::get('');

Route::prefix('formations')
    ->controller(FormationController::class)
    ->group(function() {
        Route::get('', 'index');
    });
