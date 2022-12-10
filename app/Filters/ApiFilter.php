<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter {
    private array $safeParameters = [
        // 'example' => new CombinedOperator([new Equal(), new NotEqual()])
    ];

    private array $columnMap = [
        // 'underscoreName' => 'underscore_name'
    ];

    public function __construct(array $safeParameters, array $columnMap)
    {
        $this->safeParameters = $safeParameters;
        $this->columnMap = $columnMap;
    }

    public function transform(Request $request) {
        $eloquentQuery = [];

        foreach ($this->safeParameters as $parameter => $operators) {
            $query = $request->query($parameter);
            if (!isset($query)) continue;

            $column = $this->columnMap[$parameter] ?? $parameter;

            foreach ($operators->getOperators() as $operator) {
                if (isset($query[$operator->getAbbreviation()])) {
                    $eloquentQuery[] = [
                        $column,
                        $operator->getOperator(),
                        $query[$operator->getAbbreviation()],
                    ];
                }
            }
        }
        
        return $eloquentQuery;
    }

}
