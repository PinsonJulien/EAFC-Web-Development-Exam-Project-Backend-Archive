<?php

namespace App\Http\Middleware;

use App\Http\Responses\Errors\ValidatorErrorResponse;
use App\Traits\ModelDataExtractor;
use App\Traits\RequestInfoExtractor;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SortMiddleware
{
    use RequestInfoExtractor;
    use ModelDataExtractor;

    protected const QUERY_PARAMETER_NAME = "sortBy";
    public const ATTRIBUTE_NAME = self::QUERY_PARAMETER_NAME.'Parameter';

    /**
     * Handle the sortBy query parameter
     * sortBy=asc(column1),desc(column2)
     * Ensure the given columns exists.
     *
     * @param Request $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse|ValidatorErrorResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sortByQueryParam = $request->query(self::QUERY_PARAMETER_NAME);
        if (!$sortByQueryParam)
            return $next($request);

        $model = $this->getRequestModel($request);
        $model = new $model();
        $modelColumns = $this->getModelColumns($model);

        $sortParams = [];

        $sorts = explode(',', $sortByQueryParam);

        foreach ($sorts as $sort) {
            $regex = '/^(asc|desc)\((\w+)\)$/';
            $validator = Validator::make(
                [
                    self::QUERY_PARAMETER_NAME => $sort,
                ],
                [
                    self::QUERY_PARAMETER_NAME => ['regex:'.$regex],
                ],
                [
                    'regex' => 'Invalid format, [:input] does not match: '.$regex,
                ]
            );

            if ($validator->fails())
                return new ValidatorErrorResponse($validator);

            list($order, $column) = explode('(', $sort);
            $order = trim($order);
            $column = trim(str_replace(')', '', $column));
            // allows to use the camel case, but always retransform to snake case.
            $column = Str::snake($column);

            $validator = Validator::make(
                [
                    self::QUERY_PARAMETER_NAME => $column,
                ],
                [
                    self::QUERY_PARAMETER_NAME => Rule::in($modelColumns),
                ],
                [
                    'in' => 'The [:input] column does not exist.'
                ]
            );

            if ($validator->fails())
                return new ValidatorErrorResponse($validator);

            $sortParams[] = [$column, $order];
        }

        $request->attributes->add([self::ATTRIBUTE_NAME => $sortParams]);

        return $next($request);
    }
}
