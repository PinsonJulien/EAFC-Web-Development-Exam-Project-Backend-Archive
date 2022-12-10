<?php

namespace App\Helpers\Operators;

class GreaterThan extends Operator {
    public function __construct()
    {
        parent::__construct('>', 'gt', 'Greater than');
    }
}
