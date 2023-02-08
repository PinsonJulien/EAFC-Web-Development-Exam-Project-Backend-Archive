<?php

namespace App\Helpers\Operators\CombinedOperators;

use App\Helpers\Operators\Equal;
use App\Helpers\Operators\NotEqual;

/**
 * Class to represent a group of Boolean Operators
 */
class BooleanOperators extends CombinedOperator {
    /**
     * Constructor building a CombinedOperator to group boolean operators.
     */
    public function __construct()
    {
        parent::__construct([
            new Equal(),
            new NotEqual(),
        ]);
    }
}
