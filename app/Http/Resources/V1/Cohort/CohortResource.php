<?php

namespace App\Http\Resources\V1\Cohort;

use App\Http\Resources\V1\CohortMember\CohortMemberResource;
use App\Http\Resources\V1\Formation\FormationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CohortResource extends JsonResource
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

            'name' => $this->name,
            'formation' => new FormationResource($this->formation),

            'relations' => [
                'cohortMembers' => CohortMemberResource::collection($this->whenLoaded('cohortMembers')),
            ],
        ];
    }
}
