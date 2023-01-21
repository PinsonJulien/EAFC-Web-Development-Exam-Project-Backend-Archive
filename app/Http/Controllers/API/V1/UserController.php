<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\User\StoreUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends V1Controller
{
    protected string $model = User::class;
    protected string $resource = UserResource::class;

    function __construct() {}

    /**
    * Display the specified user.
     *
     * @param  User $user
     * @return UserResource
    */
    public function show(User $user): UserResource
    {
        $user = $this->applyIncludeRelationParameters($user, request());
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->all();

        // Store the profile picture if it's uploaded.
        $picture = $request->file('picture');
        if ($picture) {
            $path = $picture->storePublicly('public/pictures');
            $data['picture'] = Storage::url($path);
        }

        return new UserResource(User::create($data));
    }

    // todo User cannot edit their own role. (logged user != user we're try to change)

}
