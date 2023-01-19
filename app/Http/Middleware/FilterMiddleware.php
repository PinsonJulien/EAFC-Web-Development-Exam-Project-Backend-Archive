<?php

namespace App\Http\Middleware;

use App\Traits\RequestInfoExtractor;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class FilterMiddleware
{
    use RequestInfoExtractor;

    /**
     * Handle the filters query parameter
     * column1[lte]=10?column1[gte]=12
     * Ensure the given columns exists and the operators match the LHS rules.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $model = $this->getRequestModel($request);
        $model = new $model();

        if (!$model::filterable)
            return $next($request);

        $filtersParams = [];

        foreach ($model::filterable as $column => $operators) {
            // Expects camel cased column names.
            $query = $request->query(Str::camel($column));
            if (!isset($query) || !is_array($query)) continue;

            $operators = new $operators();
            if (!isset($operators)) continue;

            foreach ($query as $operator => $value) {
                $operatorClass = $operators->findByAbbreviation($operator);

                if (!$operatorClass)
                    return response()->json([
                        'error' => 'filters: Invalid operator ['.$operator.'] for the column ['.$column.'].'
                    ], 400);

                // Example : ['name', '=', 'value']
                $filtersParams[] = [
                    $column,
                    $operatorClass->getOperator(),
                    $value
                ];
            }
        }

        $request->attributes->add(['filtersParams' => $filtersParams]);

        return $next($request);
    }
}
