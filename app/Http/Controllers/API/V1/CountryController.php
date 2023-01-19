<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Country\StoreCountryRequest;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;

class CountryController extends V1Controller
{
    protected string $model = Country::class;
    protected string $resource = CountryResource::class;

    function __construct() {}

    /**
    * Display the specified country.
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
