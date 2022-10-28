<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::with('teacher')->get();

        return response()->json($courses);
    }
}
