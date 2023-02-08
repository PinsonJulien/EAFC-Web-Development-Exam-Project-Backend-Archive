<?php

namespace App\Http\Requests\V1\Country;

use Illuminate\Foundation\Http\FormRequest;

/**
 * V1 Request to handle the Country POST validation
 */
class StoreCountryRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'iso' => ['required', 'string', 'alpha', 'size:2'],
        ];
    }
}
