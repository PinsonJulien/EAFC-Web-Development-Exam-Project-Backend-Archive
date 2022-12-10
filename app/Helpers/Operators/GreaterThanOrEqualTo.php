<?php

namespace App\Helpers\Operators;

class GreaterThanOrEqualTo extends Operator {
    public function __construct()
    {
        parent::__construct('>=', 'gte', 'Greater than or equal to');
    }
}
