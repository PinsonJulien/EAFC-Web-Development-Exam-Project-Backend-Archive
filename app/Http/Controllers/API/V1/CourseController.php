<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Course\StoreCourseRequest;
use App\Http\Requests\V1\Course\UpdateCourseRequest;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Course;
use App\Models\SiteRole;
use App\Models\User;
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
     * Automatically set the teacher user site_role to User.
     * Returns the created Course.
     *
     * @param StoreCourseRequest $request
     * @return CourseResource
     */
    public function store(StoreCourseRequest $request): CourseResource
    {
        $data = $request->all();
        // Update the teacher role to User if it's null or Guest.
        $user = User::find($data['teacher_user_id']);
        if ($user->isSiteRoleGuest())
            $user->changeSiteRole(SiteRole::USER);

        return new CourseResource(Course::create($data));
    }

    /**
     * Update the specified Course using the request data.
     * Automatically set the teacher user site_role to User.
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

        // Update the teacher role to User if it's null or Guest.
        $userId = $data['teacher_user_id'] ?? null;
        if ($userId) {
            $user = User::find($userId);
            if ($user->isSiteRoleGuest()) {
                $user->changeSiteRole(SiteRole::USER);
            }
        }

        $course->update($data);
        return new CourseResource($course);
    }

    /**
     * Delete the specified Course.
     *
     * @param Request $request
     * @param Course $course
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, Course $course): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $course);
    }
}
