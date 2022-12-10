<?php

namespace App\Helpers\Operators;

// Laravel supported operators:
/*
    $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>', '&~', 'is', 'is not',
        'rlike', 'not rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];
*/

abstract class Operator {
    private String $operator;
    private String $abbreviation;
    private String $fullName;

    public function __construct(String $operator, String $abbreviation, String $fullName )
    {
        $this->operator = $operator;
        $this->abbreviation = $abbreviation;
        $this->fullName = $fullName;
    }

    public function getOperator(): String {
        return $this->operator;
    }

    public function getAbbreviation(): String {
        return $this->abbreviation;
    }

    public function getFullName(): String {
        return $this->fullName;
    }
}
