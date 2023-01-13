<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\SiteRolesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SiteRole\DestroySiteRoleRequest;
use App\Http\Requests\V1\SiteRole\StoreSiteRoleRequest;
use App\Http\Resources\V1\SiteRoleCollection;
use App\Http\Resources\V1\SiteRoleResource;
use App\Models\SiteRole;
use Illuminate\Http\Request;

class SiteRoleController extends Controller
{
    protected array $relations = ['users',];

    function __construct() {}

    /**
     * Display a listing of all site roles
     *
     * @param Request $request
     * @return SiteRoleCollection
     */
    public function index(Request $request) {
        $siteRoles = $this->filterRequest(new SiteRolesFilter(), SiteRole::query(), $request);
        $siteRoles = $this->includeRequestedRelations($siteRoles, $request, $this->relations);

        return new SiteRoleCollection($siteRoles->paginate()->appends($request->query()));
    }

    /**
     * Display the specified site role
     *
     * @param SiteRole $siteRole
     * @return SiteRoleResource
     */
    public function show(SiteRole $siteRole): SiteRoleResource
    {
        $siteRole = $this->includeRequestedRelations($siteRole, request(), $this->relations);
        return new SiteRoleResource($siteRole);
    }

    public function store(StoreSiteRoleRequest $request): SiteRoleResource
    {
        return new SiteRoleResource(SiteRole::create($request->all()));
    }

    public function destroy(DestroySiteRoleRequest $request, SiteRole $siteRole) {
        $siteRole->delete();
        return response()->json(null, 204);
    }
}
