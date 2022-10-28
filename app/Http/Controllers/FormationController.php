<?php

namespace App\Http\Controllers;

use App\Models\Formation;

class FormationController extends Controller
{
    public function index() {
        $formations = Formation::with('educationLevel',)->get();

        return response()->json($formations);
    }
}
