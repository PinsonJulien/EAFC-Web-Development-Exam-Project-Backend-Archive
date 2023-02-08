<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Trait to extractor data from a model.
 */
trait ModelDataExtractor
{
    /**
     * Returns the model table columns.
     * Hidden properties removed by default.
     *
     * @param Model $model
     * @param bool $includeHidden
     * @return array
     */
    protected function getModelColumns(Model $model, bool $includeHidden = false): array {
        $tableName = $model->getTable();
        $columns = Schema::getColumnListing($tableName);

        // Remove all hidden properties.
        if (!$includeHidden)
            $columns = array_diff($columns, $model->getHidden());

        return $columns;
    }
}
