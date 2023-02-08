<?php

namespace App\Http\Resources\V1\EducationLevel;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * V1 API Collection to transform an array of EducationLevel to json.
 */
class EducationLevelCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
