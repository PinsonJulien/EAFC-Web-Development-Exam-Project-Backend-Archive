<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\EducationLevel\DestroyEducationLevelRequest;
use App\Http\Requests\V1\EducationLevel\StoreEducationLevelRequest;
use App\Http\Requests\V1\EducationLevel\UpdateEducationLevelRequest;
use App\Http\Resources\V1\EducationLevelResource;
use App\Models\EducationLevel;

class EducationLevelController extends V1Controller
{
    protected string $model = EducationLevel::class;
    protected string $resource = EducationLevelResource::class;

    function __construct() {}

    /**
     * Returns the specified EducationLevel
     *
     * @param  EducationLevel $educationLevel
     * @return EducationLevelResource
    */
    public function show(EducationLevel $educationLevel): EducationLevelResource
    {
        $educationLevel = $this->applyIncludeRelationParameters($educationLevel, request());
        return new EducationLevelResource($educationLevel);
    }

    /**
     * Insert a new EducationLevel using the request data.
     * Returns the created EducationLevel.
     *
     * @param StoreEducationLevelRequest $request
     * @return EducationLevelResource
     */
    public function store(StoreEducationLevelRequest $request): EducationLevelResource
    {
        return new EducationLevelResource(EducationLevel::create($request->all()));
    }

    /**
     * Update the specified EducationLevel using the request data.
     * Returns the updated EducationLevel.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateEducationLevelRequest $request
     * @param EducationLevel $educationLevel
     * @return EducationLevelResource
     */
    public function update(UpdateEducationLevelRequest $request, EducationLevel $educationLevel): EducationLevelResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $educationLevel->update($data);
        return new EducationLevelResource($educationLevel);
    }

    /**
     * Delete the specified EducationLevel.
     * Returns a 204 status.
     *
     * @param DestroyEducationLevelRequest $request
     * @param EducationLevel $educationLevel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyEducationLevelRequest $request, EducationLevel $educationLevel) {
        $educationLevel->delete();
        return response()->json(null, 204);
    }
}
