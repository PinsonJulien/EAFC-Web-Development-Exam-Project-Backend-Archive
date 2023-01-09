<?php

namespace App\Http\Requests\V1\Formation;

use Illuminate\Foundation\Http\FormRequest;

class DestroyFormationRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $formation = $this->route('formation');

            // If the formation has related groups, cannot be deleted.
            //if ($formation->groups()->exists())
            //    $validator->errors()->add('formation', 'Cannot delete formations related related to groups.');
        });
    }
}
