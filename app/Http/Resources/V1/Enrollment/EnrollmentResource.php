<?php

namespace App\Http\Resources\V1\Enrollment;

use App\Http\Resources\V1\Formation\FormationResource;
use App\Http\Resources\V1\Status\StatusResource;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'user' => new UserResource($this->whenLoaded('user')),
            'formation' => new FormationResource($this->whenLoaded('formation')),
            'status' => new StatusResource($this->status),
            'message' => $this->message,
        ];
    }
}
