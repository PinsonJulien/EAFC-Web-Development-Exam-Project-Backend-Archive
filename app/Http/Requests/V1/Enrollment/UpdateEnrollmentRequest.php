<?php

namespace App\Http\Requests\V1\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * V1 Request to handle the Enrollment PUT/PATCH validation
 */
class UpdateEnrollmentRequest extends FormRequest
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
            'statusId'  => ['sometimes', 'required', 'integer', 'exists:statuses,id,deleted_at,NULL'],
            'message'   => ['nullable', 'string'],
        ];
    }

    /**
     * Prepare the data for validation by changing the camel case to snake case.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status_id' => $this->statusId,
            'message' => $this->message,
        ]);
    }
}
