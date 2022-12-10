<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use App\Helpers\Operators\CombinedOperators\BooleanOperators;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;

class CoursesFilter extends ApiFilter {

    public function __construct()
    {
        parent::__construct(
            [
                'name' => new StringOperators(),
                'status' => new BooleanOperators(),
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
