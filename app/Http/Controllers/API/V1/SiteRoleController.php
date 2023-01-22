<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\SiteRole\StoreSiteRoleRequest;
use App\Http\Requests\V1\SiteRole\UpdateSiteRoleRequest;
use App\Http\Resources\V1\SiteRoleResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\SiteRole;
use Illuminate\Http\Request;

class SiteRoleController extends V1Controller
{
    protected string $model = SiteRole::class;
    protected string $resource = SiteRoleResource::class;

    function __construct() {}

    /**
     * Returns the specified SiteRole
     *
     * @param SiteRole $siteRole
     * @return SiteRoleResource
     */
    public function show(SiteRole $siteRole): SiteRoleResource
    {
        $siteRole = $this->applyIncludeRelationParameters($siteRole, request());
        return new SiteRoleResource($siteRole);
    }

    /**
     * Insert a new SiteRole using the request data.
     * Returns the created SiteRole.
     *
     * @param StoreSiteRoleRequest $request
     * @return SiteRoleResource
     */
    public function store(StoreSiteRoleRequest $request): SiteRoleResource
    {
        return new SiteRoleResource(SiteRole::create($request->all()));
    }

    /**
     * Update the specified SiteRole using the request data.
     * Returns the updated SiteRole.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateSiteRoleRequest $request
     * @param SiteRole $siteRole
     * @return SiteRoleResource
     */
    public function update(UpdateSiteRoleRequest $request, SiteRole $siteRole): SiteRoleResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $siteRole->update($data);
        return new SiteRoleResource($siteRole);
    }

    /**
     * Delete the specified SiteRole.
     *
     * @param Request $request
     * @param SiteRole $siteRole
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, SiteRole $siteRole): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $siteRole);
    }
}
