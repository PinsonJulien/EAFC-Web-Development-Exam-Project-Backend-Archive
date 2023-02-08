<?php

namespace App\Traits;

/**
 * Trait to add trait related methods to a class.
 */
trait TraitHelpers
{
    /**
     * Looks if a specified class has a specified trait.
     *
     * @param string $className
     * @param string $traitName
     * @return bool
     * @throws \ReflectionException
     */
    public static function hasTrait(string $className, string $traitName): bool
    {
        $reflector = new \ReflectionClass($className);
        return in_array($traitName, $reflector->getTraitNames());
    }
}
