<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Filters\V1\GroupsFilter;
use App\Http\Requests\V1\Group\StoreGroupRequest;
use App\Http\Resources\V1\GroupCollection;
use App\Http\Resources\V1\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected array $relations = ['users',];

    function __construct() {}

    /**
     * Display a listing of the groups
     *
     * @param Request $request
     * @return GroupCollection
     */
    public function index(Request $request) {
        $groups = $this->filterRequest(new GroupsFilter(), group::query(), $request);
        $groups = $this->includeRequestedRelations($groups, $request, $this->relations);

        return new GroupCollection($groups->paginate()->appends($request->query()));
    }

    /**
     * Display the specified group.
     *
     * @param  Group $group
     * @return GroupResource
     */
    public function show(Group $group): groupResource
    {
        $group = $this->includeRequestedRelations($group, request(), $this->relations);
        return new GroupResource($group);
    }

    public function store(StoreGroupRequest $request): GroupResource
    {
        $data = $request->all();

        return new GroupResource(Group::create($data));
    }
}
