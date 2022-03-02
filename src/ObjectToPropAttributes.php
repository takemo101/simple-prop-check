<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Exception\ExceptionFactory;
use ReflectionAttribute;
use ReflectionProperty;
use ReflectionClass;

/**
 * object to PropAttribute array transform class
 */
final class ObjectToPropAttributes
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
     * to PropAttribute array
     *
     * @return PropAttribute[]
     */
    public function toPropAttributes(): array
    {
        $result = [];

        $class = new ReflectionClass($this->object);

        /**
         * @var ReflectionProperty[]
         */
        $reflections = $class->getProperties();

        foreach ($reflections as $reflection) {
            if ($prop = $this->createPropAttributeFromReflectionProperty($reflection)) {
                $result[] = $prop;
            }
        }

        return $result;
    }

    /**
     * to prop attribute
     *
     * @param ReflectionProperty $reflection
     * @return PropAttribute|null
     */
    private function createPropAttributeFromReflectionProperty(
        ReflectionProperty $reflection,
    ): ?PropAttribute {
        /**
         * @var Validatable<mixed>[]
         */
        $validatables = [];

        /**
         * @var ExceptionFactory
         */
        $exception = null;

        $reflection->setAccessible(true);
        $attributes = $reflection->getAttributes();

        $name = $reflection->getName();
        $data = $reflection->getValue($this->object);

        foreach ($attributes as $attribute) {
            $instance = $attribute->newInstance();

            if ($instance instanceof Validatable) {
                $validatables[] = $instance;
            } else if ($instance instanceof ExceptionFactory) {
                $exception = $instance;
            }
        }

        return count($validatables) ? new PropAttribute(
            $name,
            $data,
            $validatables,
            $exception,
        ) : null;
    }

    /**
     * to PropAttribute array
     *
     * @param object $object
     * @return PropAttribute[]
     */
    public static function toArray(object $object): array
    {
        return (new self($object))->toPropAttributes();
    }
}
