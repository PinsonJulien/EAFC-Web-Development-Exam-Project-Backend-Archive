<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Cohort\StoreCohortRequest;
use App\Http\Resources\V1\CohortResource;
use App\Models\Cohort;

class CohortController extends V1Controller
{
    protected string $model = Cohort::class;
    protected string $resource = CohortResource::class;

    function __construct() {}

    /**
     * Display the specified cohort.
     *
     * @param  Cohort $cohort
     * @return CohortResource
     */
    public function show(Cohort $cohort): CohortResource
    {
        $cohort = $this->applyIncludeRelationParameters($cohort, request());
        return new CohortResource($cohort);
    }

    public function store(StoreCohortRequest $request): CohortResource
    {
        $data = $request->all();

        return new CohortResource(Cohort::create($data));
    }
}
