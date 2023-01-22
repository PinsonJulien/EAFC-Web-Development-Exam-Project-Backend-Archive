<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Status\StoreStatusRequest;
use App\Http\Requests\V1\Status\UpdateStatusRequest;
use App\Http\Resources\V1\StatusResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends V1Controller
{
    protected string $model = Status::class;
    protected string $resource = StatusResource::class;
    protected array $relations = [];

    function __construct() {}

    /**
     * Returns the specified Status.
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status): StatusResource
    {
        $status = $this->applyIncludeRelationParameters($status, request());
        return new StatusResource($status);
    }

    /**
     * Insert a new Status using the request data.
     * Returns the created Status.
     *
     * @param StoreStatusRequest $request
     * @return StatusResource
     */
    public function store(StoreStatusRequest $request): StatusResource
    {
        return new StatusResource(Status::create($request->all()));
    }

    /**
     * Update the specified Status using the request data.
     * Returns the updated Status.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateStatusRequest $request
     * @param Status $status
     * @return StatusResource
     */
    public function update(UpdateStatusRequest $request, Status $status): StatusResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $status->update($data);
        return new StatusResource($status);
    }

    /**
     * Delete the specified Status.
     *
     * @param Request $request
     * @param Status $status
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, Status $status): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $status);
    }
}
