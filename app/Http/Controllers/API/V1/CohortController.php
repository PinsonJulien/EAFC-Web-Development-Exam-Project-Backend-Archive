<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Filters\V1\CohortsFilter;
use App\Http\Requests\V1\Cohort\StoreCohortRequest;
use App\Http\Resources\V1\CohortCollection;
use App\Http\Resources\V1\CohortResource;
use App\Models\Cohort;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    protected array $relations = ['members',];

    function __construct() {}

    /**
     * Display a listing of the cohorts
     *
     * @param Request $request
     * @return CohortCollection
     */
    public function index(Request $request) {
        $cohorts = $this->filterRequest(new CohortsFilter(), Cohort::query(), $request);
        $cohorts = $this->includeRequestedRelations($cohorts, $request, $this->relations);

        return new CohortCollection($cohorts->paginate()->appends($request->query()));
    }

    /**
     * Display the specified group.
     *
     * @param  Cohort $cohort
     * @return CohortResource
     */
    public function show(Cohort $cohort): CohortResource
    {
        $cohort = $this->includeRequestedRelations($cohort, request(), $this->relations);
        return new CohortResource($cohort);
    }

    public function store(StoreCohortRequest $request): CohortResource
    {
        $data = $request->all();

        return new CohortResource(Cohort::create($data));
    }
}
