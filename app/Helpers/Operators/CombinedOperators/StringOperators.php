<?php

namespace App\Helpers\Operators\CombinedOperators;

use App\Helpers\Operators\Equal;
use App\Helpers\Operators\Like;
use App\Helpers\Operators\NotEqual;
use App\Helpers\Operators\NotLike;

class StringOperators extends CombinedOperator {
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
