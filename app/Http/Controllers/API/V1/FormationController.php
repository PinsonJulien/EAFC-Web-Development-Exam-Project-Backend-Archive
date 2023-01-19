<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Formation\DestroyFormationRequest;
use App\Http\Requests\V1\Formation\StoreFormationRequest;
use App\Http\Resources\V1\FormationResource;
use App\Models\Formation;

class FormationController extends V1Controller
{
    protected string $model = Formation::class;
    protected string $resource = FormationResource::class;

    function __construct() {}

    /**
    * Display the specified formation
     *
     * @param Formation $formation
     * @return FormationResource
    */
    public function show(Formation $formation): FormationResource
    {
        $formation = $this->applyIncludeRelationParameters($formation, request());
        return new FormationResource($formation);
    }

    public function store(StoreFormationRequest $request): FormationResource
    {
        return new FormationResource(Formation::create($request->all()));
    }

    public function destroy(DestroyFormationRequest $request, Formation $formation) {
        $formation->delete();
        return response()->json(null, 204);
    }
}
