<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use App\Helpers\Operators\CombinedOperators\BooleanOperators;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;

class FormationsFilter extends ApiFilter {
    public function __construct()
    {
        parent::__construct(
            [
                'name' => new StringOperators(),
                'status' => new BooleanOperators(),
                'startDate' => new DateOperators(),
                'endDate' => new DateOperators(),
                'educationLevelId' => new NumberOperators(),
                'createdAt' => new DateOperators(),
                'updatedAt' => new DateOperators(),
            ],
            [
                'startDate' => 'start_date',
                'endDate' => 'end_date',
                'educationLevelId' => 'education_level_id',
                'createdAt' => 'created_at',
                'updatedAt' => 'updated_at',
            ]
        );
    }
}
