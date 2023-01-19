<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Course\DestroyCourseRequest;
use App\Http\Requests\V1\Course\StoreCourseRequest;
use App\Http\Resources\V1\CourseResource;
use App\Models\Course;

class CourseController extends V1Controller
{
    protected string $model = Course::class;
    protected string $resource = CourseResource::class;

    function __construct() {}

    /**
    * Display the specified course.
     *
     * @param  Course $course
     * @return CourseResource
    */
    public function show(Course $course): CourseResource
    {
        $course = $this->applyIncludeRelationParameters($course, request());
        return new CourseResource($course);
    }

    public function store(StoreCourseRequest $request): CourseResource
    {
        return new CourseResource(Course::create($request->all()));
    }

    public function destroy(DestroyCourseRequest $request, Course $course) {
        $course->delete();
        return response()->json(null, 204);
    }
}
