<?php

namespace App\Http\Requests\V1\Country;

use Illuminate\Foundation\Http\FormRequest;

/**
 * V1 Request to handle the Country PUT/PATCH validation
 */
class UpdateCountryRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'iso' => ['required', 'string', 'alpha', 'size:2'],
        ];

        if ($this->method() === 'PATCH') {
            $rules = array_map(function($rule) {
                return array_merge($rule, ['sometimes']);
            }, $rules);
        }

        return $rules;
    }
}
