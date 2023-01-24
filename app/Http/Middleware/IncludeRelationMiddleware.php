<?php

namespace App\Http\Middleware;

use App\Http\Responses\Errors\ValidatorErrorResponse;
use App\Traits\ModelDataExtractor;
use App\Traits\Models\HasRelationships;
use App\Traits\RequestInfoExtractor;
use App\Traits\TraitHelpers;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class IncludeRelationMiddleware
{
    use RequestInfoExtractor;
    use ModelDataExtractor;
    use TraitHelpers;

    protected const QUERY_PARAMETER_NAME = "includeRelations";
    public const ATTRIBUTE_NAME = self::QUERY_PARAMETER_NAME.'Parameter';

    /**
     * Handle the includeRelations query parameter
     * includeRelations=relation1,relation2
     * Ensure the given relations exist in the model.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|ValidatorErrorResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $includeRelationsQueryParam = $request->query(self::QUERY_PARAMETER_NAME);
        if (!$includeRelationsQueryParam)
            return $next($request);

        $model = $this->getRequestModel($request);
        // Get all model relationships.
        if (self::hasTrait($model, HasRelationships::class)) {
            /** @noinspection PhpUndefinedMethodInspection */
            $modelRelations = $model::getForeignRelationships();
        }

        if (empty($modelRelations))
            return $next($request);

        $includeRelationParams = [];

        $includes = explode(',', $includeRelationsQueryParam);

        foreach ($includes as $include) {
            $validator = Validator::make(
                [
                    self::QUERY_PARAMETER_NAME => $include,
                ],
                [
                    self::QUERY_PARAMETER_NAME => Rule::in($modelRelations),
                ],
                [
                    'in' => 'The [:input] relation does not exist.'
                ]
            );

            if ($validator->fails())
                return new ValidatorErrorResponse($validator);

            $includeRelationParams[] = $include;
        }

        $request->attributes->add([self::ATTRIBUTE_NAME => $includeRelationParams]);

        return $next($request);
    }
}
