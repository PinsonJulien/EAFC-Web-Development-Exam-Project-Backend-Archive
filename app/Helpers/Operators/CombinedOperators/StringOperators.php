<?php

namespace App\Helpers\Operators\CombinedOperators;

use App\Helpers\Operators\Equal;
use App\Helpers\Operators\Like;
use App\Helpers\Operators\NotEqual;
use App\Helpers\Operators\NotLike;

/**
 * Class to represent a group of String Operators
 */
class StringOperators extends CombinedOperator {
    /**
     * Constructor building a CombinedOperator to group string operators.
     */
    public function __construct()
    {
        parent::__construct([
            new Equal(),
            new NotEqual(),
            new Like(),
            new NotLike(),
        ]);
    }
}
