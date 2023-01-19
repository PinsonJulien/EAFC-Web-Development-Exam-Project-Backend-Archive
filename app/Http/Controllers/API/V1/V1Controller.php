<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\PaginationMiddleware;
use App\Http\Middleware\SortMiddleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class V1Controller extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected string $model = "";
    protected string $resource = "";

    /**
     * Generate a collection of a model
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request) {
        $rows = $this->model::query();

        $rows = $this->applyFilterParameters($rows, $request);
        $rows = $this->applySortParameters($rows, $request);
        $rows = $this->applyIncludeRelationParameters($rows, $request);
        $rows = $this->applyPaginationParameters($rows, $request);

        // If the builder was not converted to a paginator
        if ($rows::class === Builder::class)
            $rows = $rows->get();

        return $this->resource::collection($rows);
    }

    /**
     * Apply the filter parameters from the request to the builder.
     * @param Builder $builder
     * @param Request $request
     * @return Builder
     */
    protected function applyFilterParameters(Builder $builder, Request $request) {
        $parameters = $request->attributes->get(FilterMiddleware::ATTRIBUTE_NAME);
        if ($parameters) {
            $builder = $builder->where($parameters);
        }

        return $builder;
    }

    /**
     * Apply the sorting parameters from the request to the builder.
     * @param Builder $builder
     * @param Request $request
     * @return Builder
     */
    protected function applySortParameters(Builder $builder, Request $request) {
        $parameters = $request->attributes->get(SortMiddleware::ATTRIBUTE_NAME);
        if ($parameters) {
            foreach ($parameters as $parameter) {
                $builder = $builder->orderBy(...$parameter);
            }
        }

        return $builder;
    }

    /**
     * Apply the include parameters from the request to the builder or the model.
     * @param Builder|Model $builderOrModel
     * @param Request $request
     * @return Builder|Model
     */
    protected function applyIncludeRelationParameters(Builder|Model $builderOrModel, Request $request): Builder|Model {
        $parameters = $request->attributes->get(IncludeRelationMiddleware::ATTRIBUTE_NAME);
        if ($parameters) {
            foreach ($parameters as $parameter) {
                $builderOrModel = ($builderOrModel::class === Builder::class)
                    ? $builderOrModel->with($parameter)
                    : $builderOrModel->loadMissing($parameter);
            }
        }

        return $builderOrModel;
    }

    /**
     * Apply the pagination parameters from the request to the builder or the model.
     * @param Builder $builder
     * @param Request $request
     * @return Builder|LengthAwarePaginator
     */
    protected function applyPaginationParameters(Builder $builder, Request $request): Builder|LengthAwarePaginator {
        $parameters = $request->attributes->get(PaginationMiddleware::ATTRIBUTE_NAME);
        if ($parameters) {
            $builder = $builder->paginate($parameters)
                ->appends($request->query()) ;
        }

        return $builder;
    }
}
