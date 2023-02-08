<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Greater than Operator
 */
class GreaterThan extends Operator {
    /**
     * Constructor building an Operator for the greater than operator.
     *
     */
    public function __construct()
    {
        parent::__construct('>', 'gt', 'Greater than');
    }
}
