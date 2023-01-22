<?php

namespace App\Http\Resources\V1\CohortMember;

use App\Http\Resources\V1\Cohort\CohortResource;
use App\Http\Resources\V1\CohortRole\CohortRoleResource;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CohortMemberResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'cohort' => new CohortResource($this->whenLoaded('cohort')),
            'role' => new CohortRoleResource($this->role),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
