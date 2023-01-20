<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Course\DestroyCourseRequest;
use App\Http\Requests\V1\Course\UpdateCourseRequest;
use App\Http\Requests\V1\Course\StoreCourseRequest;
use App\Http\Resources\V1\CourseResource;
use App\Models\Course;

class CourseController extends V1Controller
{
    protected string $model = Course::class;
    protected string $resource = CourseResource::class;

    function __construct() {}

    /**
     * Returns the specified course
     *
     * @param  Course $course
     * @return CourseResource
    */
    public function show(Course $course): CourseResource
    {
        $course = $this->applyIncludeRelationParameters($course, request());
        return new CourseResource($course);
    }

    /**
     * Insert a new course using the request data, returns the created course.
     *
     * @param StoreCourseRequest $request
     * @return CourseResource
     */
    public function store(StoreCourseRequest $request): CourseResource
    {
        return new CourseResource(Course::create($request->all()));
    }

    /**
     * Update the specified course using the request data, returns the updated course.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateCourseRequest $request
     * @param Course $course
     * @return CourseResource
     */
    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $course->update($request->all());
        return new CourseResource($course);
    }

    /**
     * Delete the specified course.
     *
     * @param DestroyCourseRequest $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyCourseRequest $request, Course $course) {
        $course->delete();
        return response()->json(null, 204);
    }
}
