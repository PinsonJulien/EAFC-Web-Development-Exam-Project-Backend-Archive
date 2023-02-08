<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Equal Operator
 */
class Equal extends Operator {
    /**
     * Constructor building an Operator for the equal operator.
     *
     */
    public function __construct()
    {
        parent::__construct('=', 'eq', 'Equal');
    }
}
