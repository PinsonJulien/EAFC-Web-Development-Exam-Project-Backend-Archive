<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\CoursesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Course\StoreCourseRequest;
use App\Http\Resources\V1\CourseCollection;
use App\Http\Resources\V1\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected array $relations = ['formations', 'students'];

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

    public function store(StoreCourseRequest $request): CourseResource
    {
        return new CourseResource(Course::create($request->all()));
    }
}
