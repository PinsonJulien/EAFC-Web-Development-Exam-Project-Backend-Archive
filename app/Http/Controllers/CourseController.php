<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::with('teacher', 'formations')->get();

        return response()->json($courses);
    }
}
