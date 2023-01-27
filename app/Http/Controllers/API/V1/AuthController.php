<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Auth\LoginAuthRequest;
use App\Http\Requests\V1\User\StoreUserRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class AuthController extends V1Controller
{

    /**
     * Register a new user using the UserController store method.
     * Will automatically log in the new user.
     * Returns the created User resource.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        $userController = new UserController();
        $userResource = $userController->store($request);

        $user = $userResource->resource;

        event(new Registered($user));

        Auth::login($user);

        return $userResource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }

    /**
     * Log in using the validated data in the request.
     * Return the login User resource.
     *
     * @param LoginAuthRequest $request
     * @return UserResource
     * @throws ValidationException
     */
    public function login(LoginAuthRequest $request): UserResource
    {
        $request->authenticate();
        $request->session()->regenerate();

        return new UserResource($request->user());
    }

    /**
     * Log out the current session
     * Return an No Content response.
     *
     * @param Request $request
     * @return NoContentSuccessResponse
     */
    public function logout(Request $request): NoContentSuccessResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new NoContentSuccessResponse();
    }
}
