<?php

namespace App\Helpers\Operators;

class Like extends Operator {
    public function __construct()
    {
        parent::__construct('like', 'l', 'Like');
    }
}
