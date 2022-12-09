<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter {
    protected $safeParameters = [
        // 'example' => ['eq', 'neq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        // 'underscoreName' => 'underscore_name'
    ];

    protected $operatorMap = [
        'eq' => '=',        // Equal
        'neq' => '!=',      // Not Equal
        'lt' => '<',        // Less than
        'lte' => '<=',      // Less or equal than
        'gt' => '>',        // Greater than
        'gte' => '>=',      // Greater or equal than
    ];

    public function transform(Request $request) {
        $eloquentQuery = [];

        foreach ($this->safeParameters as $parameter => $operators) {
            $query = $request->query($parameter);

            if (!isset($query)) continue;

            $column = $this->columnMap[$parameter] ?? $parameter;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloquentQuery[] = [
                        $column,
                        $this->operatorMap[$operator],
                        $query[$operator]
                    ];
                }
            }
        }

        return $eloquentQuery;
    }

}
