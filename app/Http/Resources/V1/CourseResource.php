<?php

namespace App\Http\Resources\V1;

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
            'students' => UserResource::collection($this->whenLoaded('students')),
        ];
    }
}
