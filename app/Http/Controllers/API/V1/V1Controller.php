<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilterMiddleware;
use App\Http\Middleware\IncludeRelationMiddleware;
use App\Http\Middleware\PaginationMiddleware;
use App\Http\Middleware\SortMiddleware;
use App\Http\Requests\V1\ExportRequest;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Traits\CSVUtils;
use App\Traits\ModelDataExtractor;
use App\Traits\Models\HasRelationships;
use App\Traits\TraitHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class V1Controller extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ModelDataExtractor;
    use CSVUtils;
    use TraitHelpers;

    protected string $model = "";
    protected string $resource = "";
    protected array $joinedRelations = [];

    /**
     * Returns a collection of all values of the controller model.
     * Accepted request parameters : filtering, sorting, including relations, pagination
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $rows = $this->model::query();

        $rows = $this->applyFilterParameters($rows, $request);
        $rows = $this->applySortParameters($rows, $request);
        $rows = $this->applyIncludeRelationParameters($rows, $request);
        $rows = $this->applyPaginationParameters($rows, $request);

        // If the builder was not converted to a paginator
        if ($rows::class === Builder::class)
            $rows = $rows->get();

        // Load relations
        if ($this->joinedRelations)
            $rows = $rows->load($this->joinedRelations);

        return $this->resource::collection($rows);
    }

    /**
     * Returns a stream to download the exported data.
     * Accepted request parameters : filtering, sorting, extension
     * Available extensions : CSV, JSON
     * CSV is returned by default.
     *
     * @param ExportRequest $request
     * @return StreamedResponse
     */
    public function export(ExportRequest $request): StreamedResponse {
        $includeDeleted = $request->get('includeDeleted') ?? false;
        $extension = $request->get('extension') ?? 'csv';

        $rows = $this->model::query();
        $rows = $this->applyFilterParameters($rows, $request);
        $rows = $this->applySortParameters($rows, $request);

        if ($includeDeleted) {
            $rows = $rows->withTrashed();
        }

        $rows = $rows->get();

        // Hide the deleted_at attribute if the deleted models aren't included.
        if (!$includeDeleted)
            $rows = $rows->makeHidden(['deleted_at']);

        $fileName = class_basename($this->model).".".$extension;

        // Return a generated streamed file depending on the extension.
        return response()->streamDownload(function() use ($extension, $rows) {
            switch ($extension) {
                case 'json':
                    echo $rows->toJson();
                    break;

                case 'csv':
                    // Print all the columns
                    $columns = array_keys($rows->first()->toArray());

                    // Format the columns to be valid CSV.
                    $formattedColumns = array_map(function($column) {
                        return $this->formatForCSV($column);
                    }, $columns);

                    echo implode(',', $formattedColumns)."\r\n";

                    // Print all the data for each column.
                    foreach ($rows as $row) {
                        $rows = array_map(function($column) use ($row) {
                            return $this->formatForCSV($row[$column]);
                        }, $columns);

                        echo implode(',', $rows)."\r\n";
                    }

                    break;
            }
        }, $fileName);
    }

    /**
     * Delete a specific model
     * Ensures the model doesn't have foreign key constraints.
     *
     * @param Request $request
     * @param Model $model
     * @return NoContentSuccessResponse|ConflictErrorResponse
     */
    protected function commonDestroy(Request $request, Model $model): NoContentSuccessResponse|ConflictErrorResponse {
        // Don't allow to delete if the model has any active relations.
        if (self::hasTrait($this->model, HasRelationships::class)) {
            /** @noinspection PhpUndefinedMethodInspection */
            foreach ($this->model::getForeignRelationships() as $relationship) {
                if ($model->$relationship()->exists()) {
                    $message = "Cannot delete due to foreign key constraint.";
                    $errors = [
                        $relationship => "The model has [".$relationship."] relations."
                    ];

                    return new ConflictErrorResponse($message, $errors);
                }
            }
        }
        $model->delete();
        return new NoContentSuccessResponse();
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
