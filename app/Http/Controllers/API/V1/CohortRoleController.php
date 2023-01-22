<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\CohortRole\StoreCohortRoleRequest;
use App\Http\Requests\V1\CohortRole\UpdateCohortRoleRequest;
use App\Http\Resources\V1\CohortRole\CohortRoleResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\CohortRole;
use Illuminate\Http\Request;

class CohortRoleController extends V1Controller
{
    protected string $model = CohortRole::class;
    protected string $resource = CohortRoleResource::class;

    function __construct() {}

    /**
     * Display the specified cohort role
     *
     * @param CohortRole $cohortRole
     * @return CohortRoleResource
     */
    public function show(CohortRole $cohortRole): CohortRoleResource
    {
        $cohortRole = $this->applyIncludeRelationParameters($cohortRole, request());
        return new CohortRoleResource($cohortRole);
    }

    /**
     * Insert a new CohortRole using the request data.
     * Returns the created CohortRole.
     *
     * @param StoreCohortRoleRequest $request
     * @return CohortRoleResource
     */
    public function store(StoreCohortRoleRequest $request): CohortRoleResource
    {
        return new CohortRoleResource(CohortRole::create($request->all()));
    }

    /**
     * Update the specified CohortRole using the request data.
     * Returns the updated CohortRole.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateCohortRoleRequest $request
     * @param CohortRole $cohortRole
     * @return CohortRoleResource
     */
    public function update(UpdateCohortRoleRequest $request, CohortRole $cohortRole): CohortRoleResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $cohortRole->update($data);
        return new CohortRoleResource($cohortRole);
    }

    /**
     * Delete the specified CohortRole.
     *
     * @param Request $request
     * @param CohortRole $cohortRole
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, CohortRole $cohortRole): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $cohortRole);
    }
}
