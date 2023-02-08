<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Middleware class to verify authentication
 */
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return JsonResponse|null
     */
    protected function redirectTo($request): JsonResponse|null
    {
        if (! $request->expectsJson()) {
            return response()->json(['message' => 'User not logged in.'], 401);
        }

        return null;
    }
}
