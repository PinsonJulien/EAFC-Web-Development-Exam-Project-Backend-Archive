<?php

namespace App\Helpers\Operators;

/**
 * Class to represent the Not Like Operator
 */
class NotLike extends Operator {
    /**
     * Constructor building an Operator for the Not Like operator.
     *
     */
    public function __construct()
    {
        parent::__construct('not like', 'nl', 'Not like');
    }
}
