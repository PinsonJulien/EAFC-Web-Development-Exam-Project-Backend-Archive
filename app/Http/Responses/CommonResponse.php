<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class CommonResponse extends JsonResponse
{
    /**
     * Instantiate a JsonResponse.
     *
     * @param mixed $data
     * @param int $status
     * @param array $headers    []
     * @param int $options      0
     */
    public function __construct(mixed $data, int $status, array $headers = [], int $options = 0)
    {
        parent::__construct($data, $status, $headers, $options, false);
    }
}
