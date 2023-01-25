<?php

namespace App\Http\Requests\V1\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // todo User cannot edit their own role. (logged user != user we're trying to change)
        // prohibited_if https://laravel.com/docs/9.x/validation#rule-prohibited-if

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
            'password' => ['required', 'confirmed', Password::min(8)],
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'nationalityCountryId' => ['required', 'integer', 'exists:countries,id,deleted_at,NULL'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'addressCountryId' => ['required', 'integer', 'exists:countries,id,deleted_at,NULL'],
            'phone' => ['required', 'string', 'max:50'],
            'siteRoleId' => ['sometimes','required', 'integer', 'exists:site_roles,id,deleted_at,NULL'],
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
            'nationality_country_id' => $this->nationalityCountryId,
            'address_country_id' => $this->addressCountryId,
            'postal_code' => $this->postalCode,
            'site_role_id' => $this->siteRoleId,
        ]);
    }
}
