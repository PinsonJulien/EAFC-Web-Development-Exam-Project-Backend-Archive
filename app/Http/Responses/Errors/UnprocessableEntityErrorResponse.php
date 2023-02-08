<?php

namespace App\Http\Responses\Errors;

/**
 * Response class for error responses for unprocessable entities.
 */
class UnprocessableEntityErrorResponse extends ErrorResponse
{
    /**
     * Instantiate a response formatted for unprocessable entities.
     * Use case: A resource cannot be modified due to a logical error.
     *
     * @param string $message
     * @param array $errors
     * @param array $headers        []
     * @param int $options          0
     */
    public function __construct(string $message, array $errors, array $headers = [], int $options = 0)
    {
        $status = self::HTTP_UNPROCESSABLE_ENTITY;

        parent::__construct($message, $errors, $status, $headers, $options);
    }
}
