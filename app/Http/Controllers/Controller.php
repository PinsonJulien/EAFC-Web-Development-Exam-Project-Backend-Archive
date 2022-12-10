<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Filters a builder using the request and the given Apifilter.
     *
     * @param ApiFilter $filter
     * @param Builder $builder
     * @param Request $request
     * @return Builder
    */
    protected function filterRequest(ApiFilter $filter, Builder $builder, Request $request): Builder {
        return $builder->where(
            $filter->transform($request)
        );
    }
}
