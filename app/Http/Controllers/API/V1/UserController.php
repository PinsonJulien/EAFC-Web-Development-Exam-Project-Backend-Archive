<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\User\StoreEnrollmentUserRequest;
use App\Http\Requests\V1\User\UpdateEnrollmentUserRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Enrollment;
use App\Models\Formation;
use App\Models\SiteRole;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class UserController extends V1Controller
{
    protected string $model = User::class;
    protected string $resource = UserResource::class;

    function __construct() {}

    /**
     * Returns the specified User.
     *
     * @param  User $user
     * @return UserResource
    */
    public function show(User $user): UserResource
    {
        $user = $this->applyIncludeRelationParameters($user, request());
        return new UserResource($user);
    }

    /**
     * Insert a new User using the request data.
     * Returns the created User.
     *
     * @param StoreEnrollmentUserRequest $request
     * @return UserResource
     */
    public function store(StoreEnrollmentUserRequest $request): UserResource
    {
        $data = $request->all();
        if (!$data['site_role_id']) {
            $data['site_role_id'] = SiteRole::USER;
        }

        // Store the profile picture if it's uploaded.
        $data['picture'] = $this->savePicture($request);

        return new UserResource(User::create($data));
    }

    /**
     * Update the specified User using the request data.
     * Returns the updated User.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateEnrollmentUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateEnrollmentUserRequest $request, User $user): UserResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);
        // Do not delete the role on PUT request.
        else if (!$data['site_role_id'])
            unset($data['site_role_id']);

        $user->update($data);
        return new UserResource($user);
    }

    /**
     * Delete the specified User.
     *
     * @param Request $request
     * @param User $user
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, User $user): NoContentSuccessResponse|ConflictErrorResponse
    {
        // todo Maybe remove picture after successful delete (check if response is NoContent, return it later.)
        return $this->commonDestroy($request, $user);
    }

    /**
     * Save a picture that is attached to the request.
     * Return the url or null.
     *
     * @param Request $request
     * @return string|null
     */
    protected function savePicture(Request $request): string|null
    {
        $picture = $request->file('picture');
        if (!$picture)
            return null;

        $path = $picture->storePublicly('public/pictures');
        return Storage::url($path);
    }

    // Todo deletePicture()

    /** Relation methods **/

    /**
     * Insert a specific Formation to the specified User by using the enrollment table.
     * By default, the status is set to PENDING
     * The insertion fails if there's already an enrollment pending for the formation.
     *
     * @param StoreEnrollmentUserRequest $request
     * @param User $user
     * @return ConflictErrorResponse|JsonResponse
     */
    public function storeEnrollment(StoreEnrollmentUserRequest $request, User $user): ConflictErrorResponse|JsonResponse
    {
        $defaultStatus = Status::PENDING;
        $formationId = $request->get('formation_id');

        $hasPending = $user->enrollments->contains(function($enrollment) use ($formationId, $defaultStatus) {
            return ($enrollment->formation_id == $formationId) && ($enrollment->status_id === $defaultStatus);
        });

        if ($hasPending) {
            $message = "Could not register enrollment for the formation [".$formationId."] for the user [".$user->id."], already one pending.";
            $errors = [
                'enrollment' => $message,
            ];

            return new ConflictErrorResponse($message, $errors);
        }

        // Creates the enrollment through the formation relation, with a default status.
        $user->formations()->attach($formationId, ['status_id' => $defaultStatus]);

        $resource = new UserResource($user->load('enrollments'));
        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }

    public function updateEnrollment(UpdateEnrollmentUserRequest $request, User $user, Enrollment $enrollment)
    {
        // Ensure the enrollment belongs to the user.

        // Todo, create a Enrollment routes / controller.
        // User id here has no point whatsoever in the enrollment update.

        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);



        //$user->formations()->updateExistingPivot($formation, $data);

        return new UserResource($user->load('enrollments'));
    }
}
