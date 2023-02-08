<?php

namespace App\Http\Resources\V1\Formation;

use App\Http\Resources\V1\Cohort\CohortResource;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Resources\V1\EducationLevel\EducationLevelResource;
use App\Http\Resources\V1\Enrollment\EnrollmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * V1 API Resource to transform the Formation model to json
 */
class FormationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user() ?? null;
        $isAuthorizedRole = $user && ($user->isAdministratorSiteRole() || $user->isSecretarySiteRole());

        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'name' => $this->name,
            'status' => $this->status,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'educationLevel' => new EducationLevelResource($this->educationLevel),

            'relations' => [
                'courses' => CourseResource::collection($this->whenLoaded('courses')),
                'enrollments' => $this->when($isAuthorizedRole,
                    EnrollmentResource::collection($this->whenLoaded('enrollments'))
                ),
                'cohorts' => $this->when($isAuthorizedRole,
                    CohortResource::collection($this->whenLoaded('cohorts'))
                ),
            ],
        ];
    }
}
