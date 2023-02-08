<?php

namespace App\Http\Responses\Errors;

/**
 * Response class for error responses for resource conflict.
 */
class ConflictErrorResponse extends ErrorResponse {

    /**
     * Instanciate a response formatted for conflicts
     * Use case: Deletion failed due to foreign key constraints.
     *
     * @param string $message
     * @param array $errors
     * @param array $headers        []
     * @param int $options          0
     */
    public function __construct(string $message, array $errors, array $headers = [], int $options = 0)
    {
        $status = self::HTTP_CONFLICT;

        parent::__construct($message, $errors, $status, $headers, $options);
    }
}
