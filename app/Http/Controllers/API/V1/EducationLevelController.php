<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\EducationLevel;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EducationLevelResource;
use App\Http\Resources\V1\EducationLevelCollection;
use App\Filters\V1\EducationLevelsFilter;

class EducationLevelController extends Controller
{
    /**
    * Display a listing of the education levels.
     *
     * @param Request $request
     * @return EducationLevelCollection
    */
    public function index(Request $request): EducationLevelCollection {
        $filter = new EducationLevelsFilter();
        $conditions = $filter->transform($request);
        $educationLevels = EducationLevel::where($conditions);

        if ($request->query('includeFormations')) {
            $educationLevels = $educationLevels->with('formations');
        }

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
        return new EducationLevelResource($educationLevel);
    }
}
