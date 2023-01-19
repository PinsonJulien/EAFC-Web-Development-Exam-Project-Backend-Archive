<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Status\DestroyStatusRequest;
use App\Http\Requests\V1\Status\StoreStatusRequest;
use App\Http\Resources\V1\StatusResource;
use App\Models\Status;

class StatusController extends V1Controller
{
    protected string $model = Status::class;
    protected string $resource = StatusResource::class;
    protected array $relations = [];

    function __construct() {}

    /**
     * Display the specified status
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status): StatusResource
    {
        return new StatusResource($status);
    }

    public function store(StoreStatusRequest $request): StatusResource
    {
        return new StatusResource(Status::create($request->all()));
    }

    public function destroy(DestroyStatusRequest $request, Status $status) {
        $status->delete();
        return response()->json(null, 204);
    }
}
