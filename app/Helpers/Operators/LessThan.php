<?php

namespace App\Helpers\Operators;

class LessThan extends Operator {
    public function __construct()
    {
        parent::__construct('<', 'lt', 'Less than');
    }
}
