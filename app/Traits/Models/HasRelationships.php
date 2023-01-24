<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait that holds ways to store relations of a model and related methods.
 */
trait HasRelationships
{
    /**
     * Returns an array of all the specified relationships of the model.
     * By default, returns all relationships types.
     * Non typed methods will not be matched. Be sure to type every relationship in your models.
     *
     * Solution found here: https://laracasts.com/discuss/channels/eloquent/is-there-a-way-to-list-all-relationships-of-a-model?page=1&replyId=765124
     * Modified to include an array of types to make it flexible.
     *
     * @param array $types
     * @return array
     */
    public static function getRelationships(array $types = ['Illuminate\Database\Eloquent\Relations']): array
    {
        // Filter through all the model methods
        // Compare each type of the methods to the $types array
        // Extract their name into an array.

        $reflector = new \ReflectionClass(get_called_class());
        return collect($reflector->getMethods())
            ->filter(
                fn($method) => !empty($method->getReturnType())
                    && array_filter(
                        $types, fn($type) => str_contains($method->getReturnType(), $type)
                    )
            )
            ->pluck('name')
            ->all();
    }


    /**
     * Returns an array of all foreign relationships of the model.
     *
     * @return array
     */
    public static function getForeignRelationships(): array
    {
        return self::getRelationships([
            HasMany::class,
            BelongsToMany::class,
        ]);
    }
}
