<?php

namespace App\Helpers\Operators\CombinedOperators;

use App\Helpers\Operators\Operator;

class CombinedOperator {
    private array $operators;

    public function __construct(array $operators)
    {
        $this->operators = $operators;
    }

    public function getOperators(): array {
        return $this->operators;
    }

    public function getAbbreviatedOperators(): array {
        return array_map(function($operator) {
           return $operator->getAbbreviation();
        }, $this->operators);
    }

    public function findByAbbreviation(string $abbreviation): Operator|null {
        foreach ($this->operators as $operator) {
            if ($operator->getAbbreviation() === $abbreviation)
                return $operator;
        }

        return null;
    }
}
