<?php

namespace Takemo101\SimplePropCheck\Support\ReflectionProcess;

use ReflectionAttribute;
use ReflectionProperty;
use Takemo101\SimplePropCheck\Exception\ExceptionFactory;

/**
 * reflection property to exception factory class
 */
final class ToExceptionFactory
{
    /**
     * to exception factory by reflection property
     *
     * @param ReflectionProperty $refletion
     * @return ExceptionFactory|null
     */
    public function byReflectionProperty(
        ReflectionProperty $reflection,
    ): ?ExceptionFactory {
        /**
         * @var ExceptionFactory|null
         */
        $result = null;

        $attributes = $reflection->getAttributes(ExceptionFactory::class, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            $result = $attribute->newInstance();
        }

        return $result;
    }
}
