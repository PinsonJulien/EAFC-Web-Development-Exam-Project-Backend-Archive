<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\StatusesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Status\DestroyStatusRequest;
use App\Http\Requests\V1\Status\StoreStatusRequest;
use App\Http\Resources\V1\StatusCollection;
use App\Http\Resources\V1\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    protected array $relations = [];

    function __construct() {}

    /**
     * Display a listing of all statuses
     *
     * @param Request $request
     * @return StatusCollection
     */
    public function index(Request $request) {
        $statuses = $this->filterRequest(new StatusesFilter(), Status::query(), $request);
        $statuses = $this->includeRequestedRelations($statuses, $request, $this->relations);

        return new StatusCollection($statuses->paginate()->appends($request->query()));
    }

    /**
     * Display the specified status
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status): StatusResource
    {
        $status = $this->includeRequestedRelations($status, request(), $this->relations);
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
