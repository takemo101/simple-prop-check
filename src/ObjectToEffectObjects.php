<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Exception\ExceptionFactory;
use ReflectionAttribute;
use ReflectionProperty;
use ReflectionClass;

/**
 * convert from an object array to an object that need an effects
 */
final class ObjectToEffectObjects
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
     * to array of objects that need effects
     *
     * @return object[]
     */
    public function toEffectObject(): array
    {
        $result = [];

        $class = new ReflectionClass($this->object);

        /**
         * @var ReflectionProperty[]
         */
        $reflections = $class->getProperties();

        foreach ($reflections as $reflection) {
            $objects = $this->createEffectObjectFromReflectionProperty($reflection);
            foreach ($objects as $object) {
                $result[] = $object;
            }
        }

        return $result;
    }

    /**
     * create an array of objects that needs an effect
     *
     * @param ReflectionProperty $reflection
     * @return object[]
     */
    private function createEffectObjectFromReflectionProperty(
        ReflectionProperty $reflection,
    ): array {
        $reflection->setAccessible(true);

        if (count($reflection->getAttributes(Effect::class))) {

            $object = $reflection->getValue($this->object);

            if (is_object($object)) {
                return [$object];
            } else if (is_array($object)) {
                return array_filter($object, fn ($o) => is_object($o));
            }
        }

        return [];
    }

    /**
     * to array of objects that need effects
     *
     * @param object $object
     * @return object[]
     */
    public static function toArray(object $object): array
    {
        return (new self($object))->toEffectObject();
    }
}
