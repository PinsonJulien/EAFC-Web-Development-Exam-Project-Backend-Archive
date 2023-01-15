<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\CohortRolesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CohortRole\DestroyCohortRoleRequest;
use App\Http\Requests\V1\CohortRole\StoreCohortRoleRequest;
use App\Http\Resources\V1\CohortRoleCollection;
use App\Http\Resources\V1\CohortRoleResource;
use App\Models\CohortRole;
use Illuminate\Http\Request;

class CohortRoleController extends Controller
{
    protected array $relations = [];

    function __construct() {}

    /**
     * Display a listing of all cohort roles
     *
     * @param Request $request
     * @return CohortRoleCollection
     */
    public function index(Request $request) {
        $cohortRoles = $this->filterRequest(new CohortRolesFilter(), CohortRole::query(), $request);
        $cohortRoles = $this->includeRequestedRelations($cohortRoles, $request, $this->relations);

        return new CohortRoleCollection($cohortRoles->paginate()->appends($request->query()));
    }

    /**
     * Display the specified cohort role
     *
     * @param CohortRole $cohortRole
     * @return CohortRoleResource
     */
    public function show(CohortRole $cohortRole): CohortRoleResource
    {
        $cohortRole = $this->includeRequestedRelations($cohortRole, request(), $this->relations);
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
