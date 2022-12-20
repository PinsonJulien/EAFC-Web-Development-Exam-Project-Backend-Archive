<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\EducationLevelsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EducationLevel\StoreEducationLevelRequest;
use App\Http\Resources\V1\EducationLevelCollection;
use App\Http\Resources\V1\EducationLevelResource;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationLevelController extends Controller
{
    protected array $relations = ['formations'];

    function __construct() {}

    /**
    * Display a listing of the education levels.
     *
     * @param Request $request
     * @return EducationLevelCollection
    */
    public function index(Request $request): EducationLevelCollection {
        $educationLevels = $this->filterRequest(new EducationLevelsFilter(), EducationLevel::query(), $request);
        $educationLevels  = $this->includeRequestedRelations($educationLevels , $request, $this->relations);

        return new EducationLevelCollection($educationLevels->paginate()->appends($request->query()));
    }

    /**
    * Display the specified education level.
     *
     * @param  EducationLevel $educationLevel
     * @return EducationLevelResource
    */
    public function show(EducationLevel $educationLevel): EducationLevelResource
    {
        $educationLevel = $this->includeRequestedRelations($educationLevel, request(), $this->relations);
        return new EducationLevelResource($educationLevel);
    }

    public function store(StoreEducationLevelRequest $request): EducationLevelResource
    {
        return new EducationLevelResource(EducationLevel::create($request->all()));
    }
}
