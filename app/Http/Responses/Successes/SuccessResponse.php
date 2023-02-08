<?php

namespace App\Http\Responses\Successes;

use App\Http\Responses\CommonResponse;

/**
 * Response class for success responses (200 OK)
 */
class SuccessResponse extends CommonResponse {
    /**
     * Instantiate a formatted response to return successes.
     *
     * @param string $message   ""
     * @param int $status       200
     * @param array $headers    []
     * @param int $options      0
     */
    public function __construct(string $message = "", int $status = self::HTTP_OK, array $headers = [], int $options = 0)
    {
        parent::__construct($message, $status, $headers, $options);
    }
}
