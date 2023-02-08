<?php

namespace App\Http\Requests\V1\Formation;

use Illuminate\Foundation\Http\FormRequest;

/**
 * V1 Request to handle the Formation POST validation
 */
class StoreFormationRequest extends FormRequest
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
            'status' => ['required', 'boolean'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
            'educationLevelId' => ['nullable', 'integer', 'exists:education_levels,id,deleted_at,NULL'],
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
            'education_level_id' => $this->educationLevelId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }
}
