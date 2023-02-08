<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Less than Operator
 */
class LessThan extends Operator {
    /**
     * Constructor building an Operator for the Less than operator.
     *
     */
    public function __construct()
    {
        parent::__construct('<', 'lt', 'Less than');
    }
}
