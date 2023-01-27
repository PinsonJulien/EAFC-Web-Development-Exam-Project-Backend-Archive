<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Cohort\CohortMember\StoreCohortMemberCohortRequest;
use App\Http\Requests\V1\Cohort\CohortMember\UpdateCohortMemberCohortRequest;
use App\Http\Requests\V1\Cohort\Course\StoreCourseCohortRequest;
use App\Http\Requests\V1\Cohort\StoreCohortRequest;
use App\Http\Requests\V1\Cohort\UpdateCohortRequest;
use App\Http\Requests\V1\Grade\StoreGradeRequest;
use App\Http\Resources\V1\Cohort\CohortResource;
use App\Http\Resources\V1\CohortMember\CohortMemberCollection;
use App\Http\Resources\V1\CohortMember\CohortMemberResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Errors\NotFoundErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Cohort;
use App\Models\CohortMember;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CohortController extends V1Controller
{
    protected string $model = Cohort::class;
    protected string $resource = CohortResource::class;

    function __construct() {}

    /**
     * Returns the specified cohort.
     *
     * @param  Cohort $cohort
     * @return CohortResource
     */
    public function show(Cohort $cohort): CohortResource
    {
        $cohort = $this->applyIncludeRelationParameters($cohort, request());
        return new CohortResource($cohort);
    }

    /**
     * Insert a new cohort using the request data.
     * Returns the created cohort.
     *
     * @param StoreCohortRequest $request
     * @return JsonResponse
     */
    public function store(StoreCohortRequest $request): JsonResponse
    {
        $resource = new CohortResource(Cohort::create($request->all()));
        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }

    /**
     * Update the specified cohort using the request data.
     * Returns the updated cohort.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateCohortRequest $request
     * @param Cohort $cohort
     * @return CohortResource
     */
    public function update(UpdateCohortRequest $request, Cohort $cohort): CohortResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $cohort->update($data);
        return new CohortResource($cohort);
    }

    /**
     * Delete the specified Cohort.
     * This also delete all the related CohortMembers.
     *
     * @param Request $request
     * @param Cohort $cohort
     * @return NoContentSuccessResponse
     */
    public function destroy(Request $request, Cohort $cohort) {
        // Delete all the CohortMembers before deleting the model.
        $cohort->cohortMembers()->delete();
        $cohort->delete();

        return new NoContentSuccessResponse();
    }

    /** CohortMembers methods  **/
    /**
     * Returns a collection of all CohortMembers of a specified Cohort.
     *
     * @param Request $request
     * @param Cohort $cohort
     * @return CohortMemberCollection
     */
    public function indexCohortMember(Request $request, Cohort $cohort) : CohortMemberCollection
    {
        $cohortMembers = $cohort->cohortMembers()->getQuery();
        return new CohortMemberCollection($cohortMembers->get());
    }

    /**
     * Returns a CohortMember resource for a specific User in the Cohort.
     * If the user doesn't exist, returns NotFoundResponse.
     *
     * @param Request $request
     * @param Cohort $cohort
     * @param User $user
     * @return CohortMemberResource|NotFoundErrorResponse
     */
    public function showCohortMember(Request $request, Cohort $cohort, User $user): CohortMemberResource|NotFoundErrorResponse
    {
        $cohortMember = $cohort->findCohortMemberByUser($user);

        if (!$cohortMember)
            return $this->generateCohortMemberNotFoundResponse($cohort->id, $user->id);

        return new CohortMemberResource($cohortMember);
    }

    /**
     * Insert a new CohortMember for a Cohort and User.
     * The insertion fails if there's already a CohortMember for this Cohort and User.
     * Returns the created CohortMember.
     *
     * @param StoreCohortMemberCohortRequest $request
     * @param Cohort $cohort
     * @return JsonResponse|ConflictErrorResponse
     */
    public function storeCohortMember(StoreCohortMemberCohortRequest $request, Cohort $cohort): JsonResponse|ConflictErrorResponse
    {
        $data = $request->all();
        $userId = $data['user_id'];

        // User must not already be in the cohort.
        if ($cohort->findCohortMemberByUser($userId)) {
            $message = "The Cohort [".$cohort->id."] already have the user [".$userId."] as a member.";
            $errors = [
                'user_id' => $message,
            ];
            return new ConflictErrorResponse($message, $errors);
        }

        // Create the new CohortMember
        $data['cohort_id'] = $cohort->id;
        $cohortMember = new CohortMember($data);
        $cohortMember->save();
        $resource = new CohortMemberResource($cohortMember->load(['user', 'cohort']));

        // Return it as a resource with created status.
        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }

    /**
     * Update the CohortMember using the request data.
     * Returns a CohortMember resource.
     * If the CohortMember doesn't exist, return Not found response.
     *
     * @param UpdateCohortMemberCohortRequest $request
     * @param Cohort $cohort
     * @param User $user
     * @return CohortMemberResource|NotFoundErrorResponse
     */
    public function updateCohortMember(UpdateCohortMemberCohortRequest $request, Cohort $cohort, User $user)
    {
        $data = $request->all();

        // Check if the Cohort Member exists, return 404 otherwise.
        $cohortMember = $cohort->findCohortMemberByUser($user);
        if (!$cohortMember)
            return $this->generateCohortMemberNotFoundResponse($cohort->id, $user->id);

        if ($request->method() === 'PATCH')
            $data = array_filter($data);
        // Do not delete the cohort role on PUT request.
        else if (!$data['cohort_role_id'])
            unset($data['cohort_role_id']);

        $cohortMember->update($data);
        $cohortMember->loadMissing(['user', 'cohort']);

        return new CohortMemberResource($cohortMember);
    }

    /**
     * Delete, if it exists, a CohortMember.
     * If it doesn't, returns Not found response.
     *
     * @param Request $request
     * @param Cohort $cohort
     * @param User $user
     * @return NoContentSuccessResponse|NotFoundErrorResponse
     */
    public function destroyCohortMember(Request $request, Cohort $cohort, User $user): NoContentSuccessResponse|NotFoundErrorResponse
    {
        // Check if the Cohort Member exists, return 404 otherwise.
        $cohortMember = $cohort->findCohortMemberByUser($user);
        if (!$cohortMember)
            return $this->generateCohortMemberNotFoundResponse($cohort->id, $user->id);

        $cohortMember->delete();

        return new NoContentSuccessResponse();
    }

    /**
     * Generates a Not found error response for CohortMembers.
     * Formatted using the Cohort id and User id
     *
     * @param int $cohortId
     * @param int $userId
     * @return NotFoundErrorResponse
     */
    protected function generateCohortMemberNotFoundResponse(int $cohortId, int $userId): NotFoundErrorResponse
    {
        $message = "The Cohort [".$cohortId."] does not have the user [".$userId."] as a member.";
        $errors = [
            'user' => $message
        ];

        return new NotFoundErrorResponse($message, $errors);
    }

    /** Course methods  **/

    /**
     * Subscribe every student from the Cohort to a specified course.
     * Will only subscribe students that are not already subscribed.
     * Returns the lists of all students in this cohort.
     *
     * @param StoreCourseCohortRequest $request
     * @param Cohort $cohort
     * @return JsonResponse
     */
    public function storeCourse(StoreCourseCohortRequest $request, Cohort $cohort): JsonResponse
    {
        $courseId = $request->get('course_id');
        $students = $cohort->getStudents();

        // Use the grade controller to generate new course subscriptions for each student
        $gradeController = new GradeController();
        $gradeRequest = new StoreGradeRequest();
        $gradeRequest['course_id'] = $courseId;

        foreach ($students as $student) {
            $gradeRequest['user_id'] = $student->id;
            $gradeController->store($gradeRequest);
        }

        // Returns all cohort members.
        $collection = new CohortMemberCollection($students);
        return $collection->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }
}
