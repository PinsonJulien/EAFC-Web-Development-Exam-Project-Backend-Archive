<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // todo Do not allow to set the siteRoleId if not logged in. Must be admin.
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
        return [
            'username' => ['required', 'string', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'nationalityCountryId' => ['required', 'integer', 'exists:countries,id,deleted_at,NULL'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'addressCountryId' => ['required', 'integer', 'exists:countries,id,deleted_at,NULL'],
            'phone' => ['required', 'string', 'max:50'],
            'picture' => ['nullable', 'image'],
            'siteRoleId' => ['sometimes','required', 'integer', 'exists:site_roles,id,deleted_at,NULL'],
        ];
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
