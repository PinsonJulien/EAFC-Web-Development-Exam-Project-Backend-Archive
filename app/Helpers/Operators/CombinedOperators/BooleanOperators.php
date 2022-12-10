<?php

namespace App\Helpers\Operators\CombinedOperators;

use App\Helpers\Operators\Equal;
use App\Helpers\Operators\NotEqual;

class BooleanOperators extends CombinedOperator {
    public function __construct()
    {
        parent::__construct([
            new Equal(),
            new NotEqual(),
        ]);
    }
}
