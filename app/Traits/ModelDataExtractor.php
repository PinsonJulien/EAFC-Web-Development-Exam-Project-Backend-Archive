<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait ModelDataExtractor
{
    /**
     * Returns the model table columns.
     *
     * @param Model $model
     * @return array
     */
    protected function getModelColumns(Model $model): array {
        $tableName = $model->getTable();
        return Schema::getColumnListing($tableName);
    }

    /**
     * Returns the model relations.
     *
     * @param Model $model
     * @return array
     */
    protected function getModelRelations(Model $model): array {
        return $model::relationMethods ?? [];
    }
}