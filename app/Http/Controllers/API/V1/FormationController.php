<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FormationResource;
use App\Http\Resources\V1\FormationCollection;
use App\Filters\V1\FormationsFilter;

class FormationController extends Controller
{
    protected array $relations = ['courses'];

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
}
