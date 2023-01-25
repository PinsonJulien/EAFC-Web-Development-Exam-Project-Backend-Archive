<?php

namespace App\Http\Requests\V1\Cohort\CohortMember;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCohortMemberCohortRequest extends FormRequest
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
        $rules = [
            'cohortRoleId' => ['required', 'integer', 'exists:cohort_roles,id,deleted_at,NULL'],
        ];

        if ($this->method() === 'PATCH') {
            $rules = array_map(function($rule) {
                return array_merge($rule, ['sometimes']);
            }, $rules);
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cohort_role_id' => $this->cohortRoleId,
        ]);
    }
}
