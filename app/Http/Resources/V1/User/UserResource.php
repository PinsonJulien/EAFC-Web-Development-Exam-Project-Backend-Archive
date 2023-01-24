<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\CohortMember\CohortMemberResource;
use App\Http\Resources\V1\Country\CountryResource;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Resources\V1\Enrollment\EnrollmentResource;
use App\Http\Resources\V1\Grade\GradeResource;
use App\Http\Resources\V1\SiteRole\SiteRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'picture' => Storage::url($this->picture),
            'siteRole' => new SiteRoleResource($this->siteRole),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'teacherCourses' => CourseResource::collection($this->whenLoaded('teacherCourses')),
            'enrollments' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
            'grades' => GradeResource::collection($this->whenLoaded('grades')),
            'cohortMembers' => CohortMemberResource::collection($this->whenLoaded('cohortMembers')),
        ];
    }
}
