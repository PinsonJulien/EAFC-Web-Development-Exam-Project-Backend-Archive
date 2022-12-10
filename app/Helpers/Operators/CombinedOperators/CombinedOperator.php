<?php

namespace App\Helpers\Operators\CombinedOperators;

class CombinedOperator {
    private array $operators;

    public function __construct(array $operators)
    {
        $this->operators = $operators;
    }

    public function getOperators(): array {
        return $this->operators;
    }
}
