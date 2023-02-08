<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\EducationLevel\StoreEducationLevelRequest;
use App\Http\Requests\V1\EducationLevel\UpdateEducationLevelRequest;
use App\Http\Resources\V1\EducationLevel\EducationLevelResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\EducationLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * EducationLevel controller for the V1 of the API
 */
class EducationLevelController extends V1Controller
{
    protected string $model = EducationLevel::class;
    protected string $resource = EducationLevelResource::class;

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
     * @return JsonResponse
     */
    public function store(StoreEducationLevelRequest $request): JsonResponse
    {
        $resource = new EducationLevelResource(
            EducationLevel::create($request->all())
        );
        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
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
     *
     * @param Request $request
     * @param EducationLevel $educationLevel
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, EducationLevel $educationLevel): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $educationLevel);
    }
}
