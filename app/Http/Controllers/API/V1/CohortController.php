<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Cohort\StoreCohortRequest;
use App\Http\Requests\V1\Cohort\UpdateCohortRequest;
use App\Http\Resources\V1\CohortResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Cohort;
use Illuminate\Http\Request;

class CohortController extends V1Controller
{
    protected string $model = Cohort::class;
    protected string $resource = CohortResource::class;

    function __construct() {}

    /**
     * Returns the specified cohort.
     *
     * @param  Cohort $cohort
     * @return CohortResource
     */
    public function show(Cohort $cohort): CohortResource
    {
        $cohort = $this->applyIncludeRelationParameters($cohort, request());
        return new CohortResource($cohort);
    }

    /**
     * Insert a new cohort using the request data.
     * Returns the created cohort.
     *
     * @param StoreCohortRequest $request
     * @return CohortResource
     */
    public function store(StoreCohortRequest $request): CohortResource
    {
        return new CohortResource(Cohort::create($request->all()));
    }

    /**
     * Update the specified cohort using the request data.
     * Returns the updated cohort.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateCohortRequest $request
     * @param Cohort $cohort
     * @return CohortResource
     */
    public function update(UpdateCohortRequest $request, Cohort $cohort): CohortResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $cohort->update($data);
        return new CohortResource($cohort);
    }

    /**
     * Delete the specified Cohort.
     *
     * @param Request $request
     * @param Cohort $cohort
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, Cohort $cohort) {
        return $this->commonDestroy($request, $cohort);
    }
}
