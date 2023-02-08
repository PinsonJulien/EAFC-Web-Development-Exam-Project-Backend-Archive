<?php

namespace App\Http\Resources\V1\Formation;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * V1 API Collection to transform an array of Formation to json.
 */
class FormationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
