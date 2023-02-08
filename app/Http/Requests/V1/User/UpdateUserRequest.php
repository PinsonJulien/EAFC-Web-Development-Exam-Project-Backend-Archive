<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * V1 Request to handle the User PUT/PATCH validation
 */
class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');
        // Ignores the user own email and username.

        $rules = [
            'username' => ['required', 'string', Rule::unique('users')->ignoreModel($user),],
            'email' => ['required', 'email', Rule::unique('users')->ignoreModel($user)],
            // Must own the changed account of change password.
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
                Rule::prohibitedIf(fn () => ($user->id != $this->user()->id)),
            ],
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'nationalityCountryId' => ['required', 'integer', 'exists:countries,id,deleted_at,NULL'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'addressCountryId' => ['required', 'integer', 'exists:countries,id,deleted_at,NULL'],
            'phone' => ['required', 'string', 'max:50'],
            'siteRoleId' => [
                'sometimes',
                'required',
                'integer',
                'exists:site_roles,id,deleted_at,NULL',
                // Must be admin AND not own the updated model.
                Rule::prohibitedIf(fn () => (!$this->user()->isAdministratorSiteRole()) || ($user->id == $this->user()->id)),
            ],
        ];

        if ($this->method() === 'PATCH') {
            $rules = array_map(function($rule) {
                return array_merge($rule, ['sometimes']);
            }, $rules);
        }

        return $rules;
    }

    /**
     * Prepare the data for validation by changing the camel case to snake case.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'nationality_country_id' => $this->nationalityCountryId,
            'address_country_id' => $this->addressCountryId,
            'postal_code' => $this->postalCode,
            'site_role_id' => $this->siteRoleId,
        ]);
    }
}
