<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\V1\Enrollment\UpdateEnrollmentRequest;
use App\Http\Resources\V1\Enrollment\EnrollmentResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Errors\UnprocessableEntityErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Enrollment;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class EnrollmentController extends V1Controller
{
    protected string $model = Enrollment::class;
    protected string $resource = EnrollmentResource::class;
    protected array $joinedRelations = ['user', 'formation'];

    function __construct() {}

    /**
     * Returns the specified Enrollment.
     *
     * @param  Enrollment $enrollment
     * @return EnrollmentResource
     */
    public function show(Enrollment $enrollment): EnrollmentResource
    {
        $enrollment = $this->applyIncludeRelationParameters($enrollment, request());
        $enrollment->load($this->joinedRelations);
        return new EnrollmentResource($enrollment);
    }

    /**
     * Insert a new Enrollment for a user and formation.
     * By default, the status is set to PENDING
     * The insertion fails if there's already an enrollment pending for the user to the specified formation.
     * Returns the created enrollment.
     *
     * @param StoreEnrollmentRequest $request
     * @return JsonResponse|ConflictErrorResponse
     */
    public function store(StoreEnrollmentRequest $request): JsonResponse|ConflictErrorResponse
    {
        $defaultStatus = Status::PENDING;
        $userId = $request->get('user_id');
        $formationId = $request->get('formation_id');

        $hasPending = Enrollment::where([
            ['user_id', '=', $userId],
            ['formation_id', '=', $formationId],
            ['status_id', '=', $defaultStatus],
        ])->exists();

        if ($hasPending) {
            $message = "Could not register enrollment for the formation [".$formationId."] for the user [".$userId."], already one pending.";
            $errors = [
                'status' => $message,
            ];

            return new ConflictErrorResponse($message, $errors);
        }

        $resource = new EnrollmentResource(
            Enrollment::create([
                'user_id' => $userId,
                'formation_id' => $formationId,
                'status_id' => $defaultStatus,
            ])->load($this->joinedRelations)
        );

        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }

    /**
     * Update the specified Enrollment using the request data.
     * When an Enrollment is APPROVED, automatically create a CohortMember for the student.
     * Returns the updated Enrollment.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateEnrollmentRequest $request
     * @param Enrollment $enrollment
     * @return EnrollmentResource
     */
    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment): EnrollmentResource
    {
        $data = $request->all();
        $statusId = $data['status_id'] ?? null;

        // If the status was approved
        // try to join the user to the formation's current year cohort.
        if ($statusId === Status::APPROVED) {
            // todo once the CohortMembers controller is done.
            // Could create a specific method in Cohort aswell.
            // Should have the student role.
        }

        if ($request->method() === 'PATCH')
            $data = array_filter($data);
        // Do not delete the status on PUT request.
        else if (!$data['status_id'])
            unset($data['status_id']);

        $enrollment->update($data);
        $enrollment->loadMissing($this->joinedRelations);

        return new EnrollmentResource($enrollment);
    }

    /**
     * Delete the specified Enrollment.
     * Can only be deleted by its own user
     * Can only be deleted if the status is still PENDING.
     *
     * @param Request $request
     * @param Enrollment $enrollment
     * @return NoContentSuccessResponse|ConflictErrorResponse|UnprocessableEntityErrorResponse
     */
    public function destroy(Request $request, Enrollment $enrollment): NoContentSuccessResponse|ConflictErrorResponse|UnprocessableEntityErrorResponse
    {
        $defaultStatus = Status::PENDING;

        if ($enrollment->status_id !== $defaultStatus) {
            $message = "Could not delete the Enrollment [".$enrollment->id."], because the status [".$enrollment->status_id."] is not equal to [".$defaultStatus."]";
            $errors = [
                'status' => $message,
            ];

            return new UnprocessableEntityErrorResponse($message, $errors);
        }

        return $this->commonDestroy($request, $enrollment);
    }
}
