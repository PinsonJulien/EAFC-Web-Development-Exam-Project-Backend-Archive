<?php

namespace App\Http\Middleware;

use App\Http\Responses\Errors\ConflictErrorResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware class to redirect authenticated users.
 */
class RedirectIfAuthenticated
{
    /**
     * Returns a Conflict error if there's already a logged User.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return Response|JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // If the user is authenticated, returns HTTP error.
                $message = "A session already exists for this user.";
                $errors = [
                    'session' => $message
                ];

                return new ConflictErrorResponse($message, $errors);
            }
        }

        return $next($request);
    }
}
