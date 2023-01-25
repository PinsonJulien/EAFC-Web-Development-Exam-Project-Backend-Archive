<?php

namespace App\Http\Responses\Successes;

class NoContentSuccessResponse extends SuccessResponse {
    /**
     * Instantiate a response without content.
     * Typical use : Successful delete request.
     *
     * @param array $headers    []
     * @param int $options      0
     */
    public function __construct(array $headers = [], int $options = 0)
    {
        $status = self::HTTP_NO_CONTENT;

        parent::__construct("", $status, $headers, $options);
    }
}
