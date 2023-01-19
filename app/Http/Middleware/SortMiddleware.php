<?php

namespace App\Http\Middleware;

use App\Traits\ModelDataExtractor;
use App\Traits\RequestInfoExtractor;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SortMiddleware
{
    use RequestInfoExtractor;
    use ModelDataExtractor;

    /**
     * Handle the sortBy query parameter
     * sortBy=asc(column1),desc(column2)
     * Ensure the given columns exists.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sortByQueryParam = $request->query("sortBy");
        if (!$sortByQueryParam)
            return $next($request);

        $model = $this->getRequestModel($request);
        $model = new $model();
        $modelColumns = $this->getModelColumns($model);

        $sortParams = [];

        $sorts = explode(',', $sortByQueryParam);

        foreach ($sorts as $sort) {
            if (!preg_match('/^(asc|desc)\((\w+)\)$/', $sort))
                return response()->json([
                    'error' => 'sortBy: Invalid value format.'
                ], 400);

            list($order, $column) = explode('(', $sort);
            $order = trim($order);
            $column = trim(str_replace(')', '', $column));
            // allows to use the camel case, but always retransform to snake case.
            $column = Str::snake($column);

            if (!in_array($column, $modelColumns))
                return response()->json([
                    'error' => 'sortBy: Invalid column name ['.$column.'].'
                ], 400);

            $sortParams[] = [$column, $order];
        }

        $request->attributes->add(['sortParams' => $sortParams]);

        return $next($request);
    }
}
