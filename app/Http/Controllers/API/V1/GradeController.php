<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Grade\StoreGradeRequest;
use App\Http\Requests\V1\Grade\UpdateGradeRequest;
use App\Http\Resources\V1\Grade\GradeResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Grade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class GradeController extends V1Controller
{
    protected string $model = Grade::class;
    protected string $resource = GradeResource::class;
    protected array $joinedRelations = ['user', 'course'];

    function __construct() {}

    /**
     * Returns the specified Grade.
     *
     * @param  Grade $grade
     * @return GradeResource
     */
    public function show(Grade $grade): GradeResource
    {
        $grade->load($this->joinedRelations);
        return new GradeResource($grade);
    }

    /**
     * Insert a new Grade using the request data.
     * Returns the created Grade.
     *
     * @param StoreGradeRequest $request
     * @return JsonResponse
     */
    public function store(StoreGradeRequest $request): JsonResponse
    {
        $userId = $request->get('user_id');
        $courseId = $request->get('course_id');

        $resource = new GradeResource(
            Grade::create([
                'user_id' => $userId,
                'course_id' => $courseId,
            ])->load($this->joinedRelations)
        );

        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }

    /**
     * Update the specified Grade using the request data.
     * Returns the updated Grade.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateGradeRequest $request
     * @param Grade $grade
     * @return GradeResource
     */
    public function update(UpdateGradeRequest $request, Grade $grade): GradeResource
    {
        $data = $request->all();
        $score = $data['score'] ?? null;

        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        // Keep scores that have set value of "0".
        if ($score === "0")
            $data['score'] = $score;

        $grade->update($data);
        $grade->loadMissing($this->joinedRelations);
        return new GradeResource($grade);
    }

    /**
     * Delete the specified Grade.
     *
     * @param Request $request
     * @param Grade $grade
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, Grade $grade): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $grade);
    }
}
