<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;

class CohortsFilter extends ApiFilter {

    public function __construct()
    {
        parent::__construct(
            [
                'name' => new StringOperators(),
                'createdAt' => new DateOperators(),
                'updatedAt' => new DateOperators(),
            ],
            [
                'createdAt' => 'created_at',
                'updatedAt' => 'updated_at',
            ]
        );
    }
}
