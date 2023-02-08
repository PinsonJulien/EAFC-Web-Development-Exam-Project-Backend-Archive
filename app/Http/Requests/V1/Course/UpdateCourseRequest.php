<?php

namespace App\Http\Requests\V1\Course;

use Illuminate\Foundation\Http\FormRequest;

/**
 * V1 Request to handle the Course PUT/PATCH validation
 */
class UpdateCourseRequest extends FormRequest
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
            'status' => ['required', 'boolean'],
            'teacherUserId' => ['nullable', 'integer', 'exists:users,id,deleted_at,NULL']
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
            'teacher_user_id' => $this->teacherUserId,
        ]);
    }
}
