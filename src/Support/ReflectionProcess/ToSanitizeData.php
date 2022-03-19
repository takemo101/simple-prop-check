<?php

namespace Takemo101\SimplePropCheck\Support\ReflectionProcess;

use ReflectionAttribute;
use ReflectionProperty;
use Takemo101\SimplePropCheck\Sanitizable;

/**
 * reflection property to sanitize data class
 */
final class ToSanitizeData
{
    /**
     * constructor
     *
     * @param object $object
     */
    public function __construct(
        private object $object,
    ) {
        //
    }

    /**
     * can sanitize by reflection property
     * check for readonly property of PHP8.1
     *
     * @param ReflectionProperty $reflection
     * @return boolean
     */
    private function canSanitize(
        ReflectionProperty $reflection,
    ): bool {
        return version_compare(phpversion(), '8.1.0', '>=')
            ? !$reflection->isReadOnly()
            : true;
    }

    /**
     * to sanitize data by reflection property
     *
     * @param ReflectionProperty $reflection
     * @return mixed
     */
    public function byReflectionProperty(
        ReflectionProperty $reflection,
    ): mixed {
        $data = $reflection->getValue($this->object);

        if (!$this->canSanitize($reflection)) {
            return $data;
        }

        $attributes = $reflection->getAttributes(Sanitizable::class, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            /**
             * @var Sanitizable
             */
            $sanitize = $attribute->newInstance();

            $data = $sanitize->sanitize($data);
        }

        if (count($attributes)) {
            $reflection->setValue($this->object, $data);
        }

        return $data;
    }
}
