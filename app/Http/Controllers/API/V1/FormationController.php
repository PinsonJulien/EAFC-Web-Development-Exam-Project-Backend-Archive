<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Formation\StoreCourseFormationRequest;
use App\Http\Requests\V1\Formation\StoreFormationRequest;
use App\Http\Requests\V1\Formation\UpdateFormationRequest;
use App\Http\Resources\V1\Formation\FormationResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Formation;
use App\Models\FormationCourse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class FormationController extends V1Controller
{
    protected string $model = Formation::class;
    protected string $resource = FormationResource::class;

    function __construct() {}

    /**
     * Returns the specified Formation
     *
     * @param Formation $formation
     * @return FormationResource
    */
    public function show(Formation $formation): FormationResource
    {
        $formation = $this->applyIncludeRelationParameters($formation, request());
        return new FormationResource($formation);
    }

    /**
     * Insert a new Formation using the request data.
     * Returns the created Formation.
     *
     * @param StoreFormationRequest $request
     * @return FormationResource
     */
    public function store(StoreFormationRequest $request): FormationResource
    {
        return new FormationResource(Formation::create($request->all()));
    }

    /**
     * Update the specified Formation using the request data.
     * Returns the updated Formation.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateFormationRequest $request
     * @param Formation $formation
     * @return FormationResource
     */
    public function update(UpdateFormationRequest $request, Formation $formation): FormationResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $formation->update($data);
        return new FormationResource($formation);
    }

    /**
     * Delete the specified Formation.
     *
     * @param Request $request
     * @param Formation $formation
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, Formation $formation): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $formation);
    }

    /** Relations **/

    public function storeCourse(StoreCourseFormationRequest $request, Formation $formation) {
        $courseId = $request->get('course_id');

        if ($formation->courses->contains($courseId)) {
            $message = "The course [".$courseId."] is already related to the formation [".$formation->id."].";
            $errors = [
                'courseId' => $message,
            ];

            return new ConflictErrorResponse($message, $errors);
        }

        $formation->courses()->attach($courseId);

        $resource = new FormationResource($formation->loadMissing('courses'));
        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
    }
}
