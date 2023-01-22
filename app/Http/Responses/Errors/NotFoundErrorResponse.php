<?php

namespace App\Http\Responses\Errors;

class NotFoundErrorResponse extends ErrorResponse {
    /**
     * Instanciate a response formatted for not found.
     * Use case: A resource was not found.
     *
     * @param string $message
     * @param array $errors
     * @param array $headers        []
     * @param int $options          0
     */
    public function __construct(string $message, array $errors, array $headers = [], int $options = 0)
    {
        $status = self::HTTP_NOT_FOUND;

        parent::__construct($message, $errors, $status, $headers, $options);
    }
}
