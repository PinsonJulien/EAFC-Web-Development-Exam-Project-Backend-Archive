<?php

namespace App\Http\Requests\V1\Cohort\CohortMember;

use Illuminate\Foundation\Http\FormRequest;

class StoreCohortMemberCohortRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'userId' => ['required', 'integer', 'exists:users,id,deleted_at,NULL'],
            'cohortRoleId' => ['required', 'integer', 'exists:cohort_roles,id,deleted_at,NULL'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
            'cohort_role_id' => $this->cohortRoleId,
        ]);
    }
}