<?php

namespace App\Helpers\Operators;

/**
 * Abstract class to represent an Operator (=, +, -)
 */
abstract class Operator {
    protected String $operator;
    protected String $abbreviation;
    protected String $fullName;

    /**
     * Constructor
     *
     * @param String $operator
     * @param String $abbreviation
     * @param String $fullName
     */
    public function __construct(String $operator, String $abbreviation, String $fullName )
    {
        $this->operator = $operator;
        $this->abbreviation = $abbreviation;
        $this->fullName = $fullName;
    }

    /**
     * Return the operator
     *
     * @return String
     */
    public function getOperator(): String {
        return $this->operator;
    }

    /**
     * Return the abbreviation
     *
     * @return String
     */
    public function getAbbreviation(): String {
        return $this->abbreviation;
    }

    /**
     * Return the full name
     *
     * @return String
     */
    public function getFullName(): String {
        return $this->fullName;
    }
}
