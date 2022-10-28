<?php

namespace App\Http\Controllers;

use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationLevelController extends Controller
{
    public function index() {
        $levels = EducationLevel::all();

        return response()->json($levels);
    }
}
