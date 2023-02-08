<?php

namespace App\Http\Middleware;

use App\Http\Responses\Errors\ForbiddenErrorResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Middleware class to prevent banned users to access a resource.
 */
class RestrictedMiddleware
{
    /**
     * Handle the access to resources by certain users.
     * Prevent BANNED users to access specific routes.
     *
     * @param  Request  $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user() ?? null;

        // Only allow guests and non banned users.
        if (!$user || !$user->isBannedSiteRole())
            return $next($request);

        $message = "Banned users cannot access this resource.";
        $errors = [
            'user' => [
                'siteRole' => $message
            ]
        ];

        return new ForbiddenErrorResponse($message, $errors);
    }
}
