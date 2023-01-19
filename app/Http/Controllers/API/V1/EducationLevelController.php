<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\EducationLevel\StoreEducationLevelRequest;
use App\Http\Resources\V1\EducationLevelResource;
use App\Models\EducationLevel;

class EducationLevelController extends V1Controller
{
    protected string $model = EducationLevel::class;
    protected string $resource = EducationLevelResource::class;

    function __construct() {}

    /**
    * Display the specified education level.
     *
     * @param  EducationLevel $educationLevel
     * @return EducationLevelResource
    */
    public function show(EducationLevel $educationLevel): EducationLevelResource
    {
        $educationLevel = $this->applyIncludeRelationParameters($educationLevel, request());
        return new EducationLevelResource($educationLevel);
    }

    public function store(StoreEducationLevelRequest $request): EducationLevelResource
    {
        return new EducationLevelResource(EducationLevel::create($request->all()));
    }
}
