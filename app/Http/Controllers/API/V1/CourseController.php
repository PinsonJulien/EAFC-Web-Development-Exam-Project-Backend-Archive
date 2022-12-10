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
    protected array $relations = ['formations'];

    function __construct() {}

    /**
    * Display a listing of the courses.
     *
     * @param Request $request
     * @return CourseCollection
    */
    public function index(Request $request) {
        $courses = $this->filterRequest(new CoursesFilter(), Course::query(), $request);
        $courses = $this->includeRequestedRelations($courses, $request, $this->relations);

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
        $course = $this->includeRequestedRelations($course, request(), $this->relations);
        return new CourseResource($course);
    }
}
