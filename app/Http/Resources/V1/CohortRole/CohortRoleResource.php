<?php

namespace App\Http\Resources\V1\CohortRole;

use App\Http\Resources\V1\CohortMember\CohortMemberResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * V1 API Resource to transform the CohortRole model to json
 */
class CohortRoleResource extends JsonResource
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
        $isAuthorizedRole = $user && ($user->isAdministratorSiteRole() || $user->isSecretarySiteRole());

        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'name' => $this->name,

            'relations' => $this->when($isAuthorizedRole, [
                'cohortMembers' => CohortMemberResource::collection($this->whenLoaded('cohortMembers')),
            ]),
        ];
    }
}
