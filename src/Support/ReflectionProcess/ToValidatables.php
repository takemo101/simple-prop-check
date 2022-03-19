<?php

namespace Takemo101\SimplePropCheck\Support\ReflectionProcess;

use ReflectionAttribute;
use ReflectionProperty;
use Takemo101\SimplePropCheck\Validatable;

/**
 * reflection property to validatable array class
 */
final class ToValidatables
{
    /**
     * to validatable array by reflection property
     *
     * @param ReflectionProperty $reflection
     * @return Validatable<mixed>[]
     */
    public function byReflectionProperty(
        ReflectionProperty $reflection,
    ): array {
        /**
         * @var Validatable<mixed>[]
         */
        $result = [];

        $attributes = $reflection->getAttributes(Validatable::class, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            $result[] = $attribute->newInstance();
        }

        return $result;
    }
}
