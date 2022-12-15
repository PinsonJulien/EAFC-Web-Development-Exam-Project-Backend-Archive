<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use App\Helpers\Operators\CombinedOperators\StringOperators;

class CountriesFilter extends ApiFilter {

    public function __construct()
    {
        parent::__construct(
            [
                'name' => new StringOperators(),
                'iso' => new StringOperators(),
            ],
            []
        );
    }
}
