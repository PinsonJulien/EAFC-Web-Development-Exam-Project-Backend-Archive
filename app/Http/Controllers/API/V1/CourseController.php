<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Course\DestroyCourseRequest;
use App\Http\Requests\V1\Course\UpdateCourseRequest;
use App\Http\Requests\V1\Course\StoreCourseRequest;
use App\Http\Resources\V1\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends V1Controller
{
    protected string $model = Course::class;
    protected string $resource = CourseResource::class;

    function __construct() {}

    /**
     * Returns the specified Course.
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
     * Insert a new Course using the request data.
     * Returns the created Course.
     *
     * @param StoreCourseRequest $request
     * @return CourseResource
     */
    public function store(StoreCourseRequest $request): CourseResource
    {
        return new CourseResource(Course::create($request->all()));
    }

    /**
     * Update the specified Course using the request data.
     * Returns the updated Course.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateCourseRequest $request
     * @param Course $course
     * @return CourseResource
     */
    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $course->update($data);
        return new CourseResource($course);
    }

    /**
     * Delete the specified Course.
     *
     * @param Request $request
     * @param Course $course
     * @return \App\Http\Responses\Errors\ConflictErrorResponse|\App\Http\Responses\Successes\NoContentSuccessResponse
     */
    public function destroy(Request $request, Course $course) {
        return $this->commonDestroy($request, $course);
    }
}
