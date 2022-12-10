<?php

namespace App\Helpers\Operators;

class NotEqual extends Operator {
    public function __construct()
    {
        parent::__construct('!=', 'neq', 'Not equal');
    }
}
