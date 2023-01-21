<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Country\DestroyCountryRequest;
use App\Http\Requests\V1\Country\StoreCountryRequest;
use App\Http\Requests\V1\Country\UpdateCountryRequest;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;

class CountryController extends V1Controller
{
    protected string $model = Country::class;
    protected string $resource = CountryResource::class;

    function __construct() {}

    /**
     * Returns the specified Country.
     *
     * @param  Country $country
     * @return CountryResource
    */
    public function show(Country $country): CountryResource
    {
        return new CountryResource($country);
    }

    /**
     * Insert a new Country using the request data.
     * Returns the created Country.
     *
     * @param StoreCountryRequest $request
     * @return CountryResource
     */
    public function store(StoreCountryRequest $request): CountryResource
    {
        return new CountryResource(Country::create($request->all()));
    }

    /**
     * Update the specified Country using the request data.
     * Returns the updated Country.
     * Works for both PUT and PATCH requests.
     *
     * @param UpdateCountryRequest $request
     * @param Country $country
     * @return CountryResource
     */
    public function update(UpdateCountryRequest $request, Country $country): CountryResource
    {
        $data = $request->all();
        if ($request->method() === 'PATCH')
            $data = array_filter($data);

        $country->update($data);
        return new CountryResource($country);
    }

    /**
     * Delete the specified Country.
     * Returns a 204 status.
     *
     * @param DestroyCountryRequest $request
     * @param Country $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyCountryRequest $request, Country $country) {
        $country->delete();
        return response()->json(null, 204);
    }
}
