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
         * @var ExceptionFactory
         */
        $exception = null;

        $reflection->setAccessible(true);

        $name = $reflection->getName();
        $data = $reflection->getValue($this->object);

        // get validatables
        $validatables = $this->createValidatables($reflection);

        // get exception factory
        $exception = $this->createExceptionFactory($reflection);

        return count($validatables) ? new PropAttribute(
            $name,
            $data,
            $validatables,
            $exception,
        ) : null;
    }

    /**
     * create validatable array
     *
     * @param ReflectionProperty $reflection
     * @return Validatable<mixed>[]
     */
    private function createValidatables(ReflectionProperty $reflection): array
    {
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

    /**
     * create exception factory array
     *
     * @param ReflectionProperty $reflection
     * @return ExceptionFactory|null
     */
    private function createExceptionFactory(ReflectionProperty $reflection): ?ExceptionFactory
    {
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
