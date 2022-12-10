<?php

namespace App\Helpers\Operators;

class LessThanOrEqualTo extends Operator {
    public function __construct()
    {
        parent::__construct('<=', 'lte', 'Less than or equal to');
    }
}
