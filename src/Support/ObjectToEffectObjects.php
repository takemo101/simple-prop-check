<?php

namespace Takemo101\SimplePropCheck\Support;

use Takemo101\SimplePropCheck\Effect;
use ReflectionProperty;
use ReflectionClass;
use Takemo101\SimplePropCheck\IgnoreEffect;

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
                return $this->isIgnoreEffectObject($object) ? [] : [$object];
            } else if (is_array($object)) {
                return array_filter(
                    $object,
                    fn ($o) => is_object($o)
                        ? !$this->isIgnoreEffectObject($o)
                        : false,
                );
            }
        }

        return [];
    }

    /**
     * is ignore effect object
     *
     * @param object $object
     * @return boolean
     */
    private function isIgnoreEffectObject(object $object): bool
    {
        $reflection = new ReflectionClass($object);

        return count($reflection->getAttributes(IgnoreEffect::class)) > 0;
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
