<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Not equal Operator
 */
class NotEqual extends Operator {
    /**
     * Constructor building an Operator for the Not Equal operator.
     *
     */
    public function __construct()
    {
        parent::__construct('!=', 'neq', 'Not equal');
    }
}
