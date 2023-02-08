<?php

namespace App\Http\Responses\Errors;

/**
 * Response class for error responses for forbidden access.
 */
class ForbiddenErrorResponse extends ErrorResponse {

    /**
     * Instantiate a response formatted for forbidden access
     * Use case: A user doesn't have the specific role required to access a resource.
     *
     * @param string $message
     * @param array $errors
     * @param array $headers        []
     * @param int $options          0
     */
    public function __construct(string $message, array $errors, array $headers = [], int $options = 0)
    {
        $status = self::HTTP_FORBIDDEN;

        parent::__construct($message, $errors, $status, $headers, $options);
    }
}
