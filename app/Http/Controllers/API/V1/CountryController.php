<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\CountriesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Country\StoreCountryRequest;
use App\Http\Resources\V1\CountryCollection;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    function __construct() {}

    /**
    * Display a listing of the courses.
     *
     * @param Request $request
     * @return CountryCollection
    */
    public function index(Request $request) {
        $countries = $this->filterRequest(new CountriesFilter(), Country::query(), $request);

        return new CountryCollection($countries->paginate()->appends($request->query()));
    }

    /**
    * Display the specified course.
     *
     * @param  Country $country
     * @return CountryResource
    */
    public function show(Country $country): CountryResource
    {
        return new CountryResource($country);
    }

    public function store(StoreCountryRequest $request): CountryResource
    {
        return new CountryResource(Country::create($request->all()));
    }
}
