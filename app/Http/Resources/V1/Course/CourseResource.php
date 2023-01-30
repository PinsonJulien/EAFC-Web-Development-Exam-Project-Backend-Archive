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
        $user = $request->user() ?? null;
        // All the personal data can be seen when accessing their own profile.
        // Admins and secretaries can also see all the data.
        $isOwnUserOrAuthorizedRole = $user && (
            ($user->id == $this->id) || $user->isAdministratorSiteRole() || $user->isSecretarySiteRole()
        );

        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'name' => $this->name,
            'status' => $this->status,
            'teacher' => new UserResource($this->teacher),

            'relations' => [
                'formations' => FormationResource::collection($this->whenLoaded('formations')),
                'grades' => $this->when($isOwnUserOrAuthorizedRole,
                    GradeResource::collection($this->whenLoaded('grades'))
                ),
            ],
        ];
    }
}
