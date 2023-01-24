<?php

namespace App\Http\Responses\Errors;

class LockedErrorResponse extends ErrorResponse {

    /**
     * Instanciate a response formatted for locked resources.
     * Use case: Update/Delete failed due a specific condition to do not allow to change the resource.
     *
     * @param string $message
     * @param array $errors
     * @param array $headers        []
     * @param int $options          0
     */
    public function __construct(string $message, array $errors, array $headers = [], int $options = 0)
    {
        $status = self::HTTP_LOCKED;

        parent::__construct($message, $errors, $status, $headers, $options);
    }
}
