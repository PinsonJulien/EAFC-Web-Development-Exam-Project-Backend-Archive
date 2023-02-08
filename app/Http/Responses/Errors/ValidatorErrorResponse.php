<?php

namespace App\Http\Responses\Errors;

use Illuminate\Validation\Validator;

/**
 * Response class for error responses that failed a validation.
 */
class ValidatorErrorResponse extends ErrorResponse {

    /**
     * Instantiate a response formatted using a validator.
     *
     * @param Validator $validator
     * @param array $headers        []
     * @param int $options          0
     */
    public function __construct(Validator $validator, array $headers = [], int $options = 0)
    {
        $status = self::HTTP_UNPROCESSABLE_ENTITY;

        $message = $validator->messages()->first();
        $errors = $validator->messages()->toArray();

        parent::__construct($message, $errors, $status, $headers, $options);
    }
}
