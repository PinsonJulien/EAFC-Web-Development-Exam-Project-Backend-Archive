<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\CohortRole\DestroyCohortRoleRequest;
use App\Http\Requests\V1\CohortRole\StoreCohortRoleRequest;
use App\Http\Resources\V1\CohortRoleResource;
use App\Models\CohortRole;

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
        return new CohortRoleResource($cohortRole);
    }

    public function store(StoreCohortRoleRequest $request): CohortRoleResource
    {
        return new CohortRoleResource(CohortRole::create($request->all()));
    }

    public function destroy(DestroyCohortRoleRequest $request, CohortRole $cohortRole) {
        $cohortRole->delete();
        return response()->json(null, 204);
    }
}
