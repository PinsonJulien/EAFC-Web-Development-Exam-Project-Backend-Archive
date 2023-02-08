<?php

namespace App\Http\Resources\V1\Course;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * V1 API Resource to transform the Course model to json
 */
class CourseCollection extends ResourceCollection
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
