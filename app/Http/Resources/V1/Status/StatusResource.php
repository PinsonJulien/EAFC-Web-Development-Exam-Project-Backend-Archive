<?php

namespace App\Http\Resources\V1\Status;

use App\Http\Resources\V1\Enrollment\EnrollmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
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
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'enrollments' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
        ];
    }
}
