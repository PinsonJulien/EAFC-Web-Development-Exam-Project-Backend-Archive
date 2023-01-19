<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\SiteRole\DestroySiteRoleRequest;
use App\Http\Requests\V1\SiteRole\StoreSiteRoleRequest;
use App\Http\Resources\V1\SiteRoleResource;
use App\Models\SiteRole;

class SiteRoleController extends V1Controller
{
    protected string $model = SiteRole::class;
    protected string $resource = SiteRoleResource::class;

    function __construct() {}

    /**
     * Display the specified site role
     *
     * @param SiteRole $siteRole
     * @return SiteRoleResource
     */
    public function show(SiteRole $siteRole): SiteRoleResource
    {
        $siteRole = $this->applyIncludeRelationParameters($siteRole, request());
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
