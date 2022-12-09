<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CoursesFilter extends ApiFilter {

    protected $safeParameters = [
        'name' => ['eq', 'neq',],
        'status' => ['eq', 'neq'],
        'createdAt' => ['eq', 'neq', 'lt', 'lte', 'gt', 'gte'],
        'updatedAt' => ['eq', 'neq', 'lt', 'lte', 'gt', 'gte'],
    ];

    protected $columnMap = [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

}
