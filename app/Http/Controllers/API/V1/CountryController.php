<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\Country\StoreCountryRequest;
use App\Http\Requests\V1\Country\UpdateCountryRequest;
use App\Http\Resources\V1\Country\CountryResource;
use App\Http\Responses\Errors\ConflictErrorResponse;
use App\Http\Responses\Successes\NoContentSuccessResponse;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

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
        $country = $this->applyIncludeRelationParameters($country, request());
        return new CountryResource($country);
    }

    /**
     * Insert a new Country using the request data.
     * Returns the created Country.
     *
     * @param StoreCountryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        $resource = new CountryResource(Country::create($request->all()));
        return $resource->response()->setStatusCode(HTTPResponse::HTTP_CREATED);
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
     *
     * @param Request $request
     * @param Country $country
     * @return ConflictErrorResponse|NoContentSuccessResponse
     */
    public function destroy(Request $request, Country $country): NoContentSuccessResponse|ConflictErrorResponse
    {
        return $this->commonDestroy($request, $country);
    }
}
