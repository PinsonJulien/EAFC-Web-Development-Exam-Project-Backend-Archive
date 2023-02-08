<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Greater than or equal Operator
 */
class GreaterThanOrEqualTo extends Operator {
    /**
     * Constructor building an Operator for the Greater than or equal to operator.
     *
     */
    public function __construct()
    {
        parent::__construct('>=', 'gte', 'Greater than or equal to');
    }
}
