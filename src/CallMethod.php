<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Exception\ExceptionFactory;
use ReflectionAttribute;
use ReflectionClass;

/**
 * call the method set in the AfterCall attribute
 */
final class CallMethod
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
     * call the method
     *
     * @return void
     */
    public function call(): void
    {
        $class = new ReflectionClass($this->object);

        $attributes = $class->getAttributes(AfterCall::class);

        if (count($attributes)) {

            $attribute = $attributes[0];

            /**
             * @var AfterCall
             */
            $instance = $attribute->newInstance();
            $method = $instance->getCallMethodName();

            if ($class->hasMethod($method)) {

                $reflection = $class->getMethod($method);
                $reflection->setAccessible(true);

                $reflection->invoke($this->object);
            }
        }
    }

    /**
     * call the method
     *
     * @param object $object
     * @return void
     */
    public static function toCall(object $object): void
    {
        (new self($object))->call();
    }
}
