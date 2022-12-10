<?php

namespace App\Helpers\Operators;

class NotLike extends Operator {
    public function __construct()
    {
        parent::__construct('not like', 'nl', 'Not like');
    }
}
