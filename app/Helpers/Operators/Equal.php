<?php

namespace App\Helpers\Operators;

class Equal extends Operator {
    public function __construct()
    {
        parent::__construct('=', 'eq', 'Equal');
    }
}
