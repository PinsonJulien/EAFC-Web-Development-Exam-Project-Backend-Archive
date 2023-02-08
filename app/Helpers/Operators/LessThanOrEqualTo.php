<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Less than or equal Operator
 */
class LessThanOrEqualTo extends Operator {
    /**
     * Constructor building an Operator for the Less than or equal to operator.
     *
     */
    public function __construct()
    {
        parent::__construct('<=', 'lte', 'Less than or equal to');
    }
}
