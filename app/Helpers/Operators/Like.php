<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Like Operator
 */
class Like extends Operator {
    /**
     * Constructor building an Operator for the Like operator.
     *
     */
    public function __construct()
    {
        parent::__construct('like', 'l', 'Like');
    }
}
