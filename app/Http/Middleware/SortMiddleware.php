<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SortMiddleware
{
    /**
     * Handle an incoming request.
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

        // Get the controller class name.
        $routeAction = $request->route()->getAction();
        $controller = class_basename($routeAction['controller']);
        // removes the @function
        $controller = strtok($controller, '@');
        // Get the model name
        $model = str_replace("Controller", "", $controller);
        $model = '\App\Models\\' . $model;
        $model = new $model();

        $modelColumns = $model
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($model->getTable());

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
