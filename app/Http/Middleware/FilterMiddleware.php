<?php

namespace App\Http\Middleware;

use App\Http\Responses\Errors\ValidatorErrorResponse;
use App\Traits\RequestInfoExtractor;
use Closure;
use Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Middleware class to handle filters in the query parameters.
 */
class FilterMiddleware
{
    use RequestInfoExtractor;

    protected const QUERY_PARAMETER_NAME = "filter";
    public const ATTRIBUTE_NAME = self::QUERY_PARAMETER_NAME.'Parameter';

    /**
     * Handle the filtering query parameters
     * column1[lte]=10?column1[gte]=12
     * Ensure the given columns exists and the operators match the LHS rules.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|ValidatorErrorResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $model = $this->getRequestModel($request);
        $model = new $model();

        // Filterable is optional in models.
        try {
            $filterableColumns = $model::filterable;
        } catch (Error $e) {
            $filterableColumns = null;
        }

        if (!$filterableColumns)
            return $next($request);

        $filtersParams = [];

        foreach ($filterableColumns as $column => $operators) {
            // Expects camel cased column names.
            $query = $request->query(Str::camel($column));
            if (!isset($query) || !is_array($query)) continue;

            $operators = new $operators();
            if (!isset($operators)) continue;

            foreach ($query as $operator => $value) {
                $operatorClass = $operators->findByAbbreviation($operator);

                $validator = Validator::make(
                    [
                        self::QUERY_PARAMETER_NAME => $operatorClass,
                    ],
                    [
                        self::QUERY_PARAMETER_NAME => ['required:'],
                    ],
                    [
                        'required' => 'The operator ['.$operator.'] does not exist for the column ['.$column.']'
                    ]
                );

                if ($validator->fails())
                    return new ValidatorErrorResponse($validator);

                // Example : ['name', '=', 'value']
                $filtersParams[] = [
                    $column,
                    $operatorClass->getOperator(),
                    $value
                ];
            }
        }

        $request->attributes->add([self::ATTRIBUTE_NAME => $filtersParams]);

        return $next($request);
    }
}
