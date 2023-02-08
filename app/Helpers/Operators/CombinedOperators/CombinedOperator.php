<?php

namespace App\Helpers\Operators\CombinedOperators;

use App\Helpers\Operators\Operator;

/**
 * Class to represent a group of Operators
 */
class CombinedOperator {
    protected array $operators;

    /**
     * Constructor to create an array of operators
     *
     * @param array $operators
     */
    public function __construct(array $operators)
    {
        $this->operators = $operators;
    }

    /**
     * Returns the operators
     *
     * @return array
     */
    public function getOperators(): array {
        return $this->operators;
    }

    /**
     * Return the abbreviations of the operators
     *
     * @return array
     */
    public function getAbbreviatedOperators(): array {
        return array_map(function($operator) {
           return $operator->getAbbreviation();
        }, $this->operators);
    }

    /**
     * Looks for a specific abbreviation in the array
     *
     * @param string $abbreviation
     * @return Operator|null
     */
    public function findByAbbreviation(string $abbreviation): Operator|null {
        foreach ($this->operators as $operator) {
            if ($operator->getAbbreviation() === $abbreviation)
                return $operator;
        }

        return null;
    }
}
