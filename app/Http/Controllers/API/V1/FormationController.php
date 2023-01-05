<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\FormationsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Formation\StoreFormationRequest;
use App\Http\Resources\V1\FormationCollection;
use App\Http\Resources\V1\FormationResource;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    protected array $relations = ['courses', 'students'];

    function __construct() {}

    /**
    * Display a listing of all formations
     *
     * @param Request $request
     * @return FormationCollection
    */
    public function index(Request $request) {
        $formations = $this->filterRequest(new FormationsFilter(), Formation::query(), $request);
        $formations = $this->includeRequestedRelations($formations, $request, $this->relations);

        return new FormationCollection($formations->paginate()->appends($request->query()));
    }

    /**
    * Display the specified formation
     *
     * @param Formation $formation
     * @return FormationResource
    */
    public function show(Formation $formation): FormationResource
    {
        $formation = $this->includeRequestedRelations($formation, request(), $this->relations);
        return new FormationResource($formation);
    }

    public function store(StoreFormationRequest $request): FormationResource
    {
        return new FormationResource(Formation::create($request->all()));
    }
}
