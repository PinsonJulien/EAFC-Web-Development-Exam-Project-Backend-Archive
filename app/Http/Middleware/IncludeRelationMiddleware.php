<?php

namespace App\Http\Middleware;

use App\Traits\ModelDataExtractor;
use App\Traits\RequestInfoExtractor;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncludeRelationMiddleware
{
    use RequestInfoExtractor;
    use ModelDataExtractor;

    protected const QUERY_PARAMETER_NAME = "includeRelations";
    public const ATTRIBUTE_NAME = self::QUERY_PARAMETER_NAME.'Parameter';

    /**
     * Handle the includeRelations query parameter
     * includeRelations=relation1,relation2
     * Ensure the given relations exist in the model.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $includeRelationsQueryParam = $request->query(self::QUERY_PARAMETER_NAME);
        if (!$includeRelationsQueryParam)
            return $next($request);

        $model = $this->getRequestModel($request);
        $model = new $model();

        $modelRelations = $this->getModelRelations($model);

        if (empty($modelRelations))
            return $next($request);

        $includeRelationParams = [];

        $includes = explode(',', $includeRelationsQueryParam);

        foreach ($includes as $include) {
            if (!in_array($include, $modelRelations))
                return response()->json([
                    'error' => 'includeRelation: Invalid relation name ['.$include.'].'
                ], 400);

            $includeRelationParams[] = $include;
        }

        $request->attributes->add([self::ATTRIBUTE_NAME => $includeRelationParams]);

        return $next($request);
    }
}
