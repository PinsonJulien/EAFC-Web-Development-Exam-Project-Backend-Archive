<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CourseResource;
use App\Http\Resources\V1\CourseCollection;
use App\Filters\V1\CoursesFilter;

class CourseController extends Controller
{
    function __construct() {}

    /**
    * Display a listing of the courses.
     *
     * @param Request $request
     * @return CourseCollection
    */
    public function index(Request $request) {
        $courses = $this->filterRequest(new CoursesFilter(), Course::query(), $request);

        if ($request->query('includeFormations')) {
            $courses = $courses->with('formations');
        }

        return new CourseCollection($courses->paginate()->appends($request->query()));
    }

    /**
    * Display the specified course.
     *
     * @param  Course $course
     * @return CourseResource
    */
    public function show(Course $course): CourseResource
    {
        return new CourseResource($course);
    }
}
