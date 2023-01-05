<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'nationality' => new CountryResource($this->nationality),
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'postalCode' => $this->postal_code,
            'addressCountry' => new CountryResource($this->addressCountry),
            'phone' => $this->phone,
            'picture' => $this->picture,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'studentCourses' => CourseResource::collection($this->whenLoaded('studentCourses')),
            'teacherCourses' => CourseResource::collection($this->whenLoaded('teacherCourses')),
            'studentFormations' => FormationResource::collection($this->whenLoaded('studentFormations')),
        ];
    }
}
