<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;

class UsersFilter extends ApiFilter {

    public function __construct()
    {
        parent::__construct(
            [
                'username' => new StringOperators(),
                'email' => new StringOperators(),
                'emailVerifiedAt' => new DateOperators(),
                'lastname' => new StringOperators(),
                'firstname' => new StringOperators(),
                'nationalityId' => new NumberOperators(),
                'birthdate' => new DateOperators(),
                'address' => new StringOperators(),
                'postalCode' => new StringOperators(),
                'addressCountryId' => new NumberOperators(),
                'phone' => new StringOperators(),
                'createdAt' => new DateOperators(),
                'updatedAt' => new DateOperators(),
            ],
            [
                'emailVerifiedAt' => 'email_verified_at',
                'nationalityId' => 'nationality_country_id',
                'postalCode' => 'postal_code',
                'addressCountryId' => 'address_country_id',
                'createdAt' => 'created_at',
                'updatedAt' => 'updated_at',
            ]
        );
    }
}
