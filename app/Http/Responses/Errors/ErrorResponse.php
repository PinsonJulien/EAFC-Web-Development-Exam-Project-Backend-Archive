<?php

namespace App\Http\Responses\Errors;

use App\Http\Responses\CommonResponse;

class ErrorResponse extends CommonResponse {
    /**
     * Instanciate a formatted response to return errors.
     *
     * @param string $message
     * @param array $errors
     * @param int $status       400
     * @param array $headers    []
     * @param int $options      0
     */
    public function __construct(string $message, array $errors, int $status = self::HTTP_BAD_REQUEST, array $headers = [], int $options = 0)
    {
        $content = [
            "message" => $message,
            "errors" => $errors
        ];

        parent::__construct($content, $status, $headers, $options);
    }
}
