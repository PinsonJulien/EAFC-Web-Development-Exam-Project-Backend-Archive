<?php

namespace App\Http\Requests\V1\User\Picture;

use Illuminate\Foundation\Http\FormRequest;

/**
 * V1 Request to handle the User/picture POST validation
 */
class StorePictureUserRequest extends FormRequest
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
            'picture' => ['required', 'image'],
        ];
    }
}
