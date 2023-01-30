<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PaginationMiddleware
{
    protected const QUERY_PARAMETER_NAME = "pagination";
    public const ATTRIBUTE_NAME = self::QUERY_PARAMETER_NAME.'Parameter';

    /**
     * Handle the pagination query parameter
     * example: pagination=15
     *
     * @param  Request  $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $value = $request->query(self::QUERY_PARAMETER_NAME);

        if (!$value)
            return $next($request);

        $request->validate([
            self::QUERY_PARAMETER_NAME => ['integer', 'gte:1'],
        ]);

        $request->attributes->add([self::ATTRIBUTE_NAME => $value]);

        return $next($request);
    }
}
