<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\User\StoreUserRequest;
use App\Http\Requests\V1\User\UpdateUserRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\SiteRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * @param StoreUserRequest $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request): UserResource
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
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
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

    // Todo destroyPicture(), storePicture
}
