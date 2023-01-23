<?php

namespace App\Http\Requests\V1\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
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
            'formationId'   => ['required', 'integer', 'exists:formations,id,deleted_at,NULL'],
            'userId'        => ['required', 'integer', 'exists:users,id,deleted_at,NULL'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'formation_id' => $this->formationId,
            'user_id' => $this->userId,
        ]);
    }
}