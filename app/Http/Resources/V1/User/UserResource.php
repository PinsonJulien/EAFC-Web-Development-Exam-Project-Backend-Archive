<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\CohortMember\CohortMemberResource;
use App\Http\Resources\V1\Country\CountryResource;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Resources\V1\Enrollment\EnrollmentResource;
use App\Http\Resources\V1\Grade\GradeResource;
use App\Http\Resources\V1\SiteRole\SiteRoleResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * V1 API Resource to transform the User model to json
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user() ?? null;

        // All the personal data can be seen when accessing their own profile.
        // Admins and secretaries can also see all the data.
        $isOwnUserOrAuthorizedRole = $user && (
            ($user->id == $this->id) || $user->isAdministratorSiteRole() || $user->isSecretarySiteRole()
        );

        // Checks if the picture is already a URL.
        $picture = $this->picture;
        if ($picture) {
            $picture = (filter_var($picture, FILTER_VALIDATE_URL))
                ? $this->picture
                : Storage::url($picture);
        }

        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'picture' => $picture,
            'account' => $this->when($isOwnUserOrAuthorizedRole, [
                'username' => $this->username,
                'email' => $this->email,
                'emailVerifiedAt' => $this->email_verified_at,
                'siteRole' => new SiteRoleResource($this->siteRole),
                'lastLogin' => $this->last_login,
            ]),
            'personal' => [
                'identity' => [
                    'lastname' => $this->lastname,
                    'firstname' => $this->firstname,
                    'nationality' => $this->when($isOwnUserOrAuthorizedRole, new CountryResource($this->nationality)),
                    'birthdate' => $this->when($isOwnUserOrAuthorizedRole, $this->birthdate),
                ],
                'contact' => $this->when($isOwnUserOrAuthorizedRole, [
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'postalCode' => $this->postal_code,
                    'country' => new CountryResource($this->addressCountry),
                ]),
            ],

            'relations' => $this->when($isOwnUserOrAuthorizedRole, [
                'teacherCourses' => CourseResource::collection($this->whenLoaded('teacherCourses')),
                'enrollments' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
                'grades' => GradeResource::collection($this->whenLoaded('grades')),
                'cohortMembers' => CohortMemberResource::collection($this->whenLoaded('cohortMembers')),
            ]),
        ];
    }
}
