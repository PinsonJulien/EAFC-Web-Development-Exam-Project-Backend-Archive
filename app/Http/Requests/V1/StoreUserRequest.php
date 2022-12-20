<?php

namespace App\Http\Requests\V1;

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
            'nationalityCountryId' => ['required', 'integer', 'exists:countries,id'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'addressCountryId' => ['required', 'integer', 'exists:countries,id'],
            'phone' => ['required', 'string', 'max:50'],
            'picture' => ['nullable', 'image'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'nationality_country_id' => $this->nationalityCountryId,
            'address_country_id' => $this->addressCountryId,
            'postal_code' => $this->postalCode,
        ]);
    }
}
