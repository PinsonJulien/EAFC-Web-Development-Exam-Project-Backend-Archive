<?php

namespace App\Http\Resources\V1\SiteRole;

use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteRoleResource extends JsonResource
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
        $isAuthorizedRole = $user && $user->isAdministratorSiteRole();

        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'name' => $this->name,

            'relations' => $this->when($isAuthorizedRole, [
                'users' => UserResource::collection($this->whenLoaded('users')),
            ]),
        ];
    }
}
