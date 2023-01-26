<?php

namespace App\Http\Resources\V1\EducationLevel;

use App\Http\Resources\V1\Formation\FormationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'name' => $this->name,
            'relations' => [
                'formations' => FormationResource::collection($this->whenLoaded('formations')),
            ],
        ];
    }
}
