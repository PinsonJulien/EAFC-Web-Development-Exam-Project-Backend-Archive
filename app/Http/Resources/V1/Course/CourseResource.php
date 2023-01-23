<?php

namespace App\Http\Resources\V1\Course;

use App\Http\Resources\V1\Formation\FormationResource;
use App\Http\Resources\V1\Grade\GradeResource;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'teacher' => new UserResource($this->teacher),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'formations' => FormationResource::collection($this->whenLoaded('formations')),
            'grades' => GradeResource::collection($this->whenLoaded('grades')),
        ];
    }
}