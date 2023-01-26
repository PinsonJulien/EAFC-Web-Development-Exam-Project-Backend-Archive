<?php

namespace App\Http\Resources\V1\Country;

use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'iso' => $this->iso,

            'relations' => [
                'nationalityUsers' => UserResource::collection($this->whenLoaded('nationalityUsers')),
                'addressUsers' => UserResource::collection($this->whenLoaded('addressUsers')),
            ],
        ];
    }
}
