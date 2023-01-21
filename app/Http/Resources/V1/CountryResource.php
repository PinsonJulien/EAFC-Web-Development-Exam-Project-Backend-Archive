<?php

namespace App\Http\Resources\V1;

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
            'name' => $this->name,
            'iso' => $this->iso,
            'nationalityUsers' => UserResource::collection($this->whenLoaded('nationalityUsers')),
            'addressUsers' => UserResource::collection($this->whenLoaded('addressUsers')),
        ];
    }
}
