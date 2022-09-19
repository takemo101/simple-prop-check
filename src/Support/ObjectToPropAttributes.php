<?php

namespace Takemo101\SimplePropCheck\Support;

use Takemo101\SimplePropCheck\Exception\ExceptionFactory;
use Takemo101\SimplePropCheck\PropAttribute;
use Takemo101\SimplePropCheck\Support\ReflectionProcess\{
    ToExceptionFactory,
    ToSanitizeData,
    ToValidatables,
};
use ReflectionProperty;
use ReflectionClass;

/**
 * convert from an object to a PropAttribute array
 */
final class ObjectToPropAttributes
{

    private ToExceptionFactory $toExceptionFactory;

    private ToSanitizeData $toSanitizeData;

    private ToValidatables $toValidatables;

    /**
     * constructor
     *
     * @param object $object
     */
    public function __construct(
        private object $object,
    ) {
        $this->toExceptionFactory = new ToExceptionFactory;
        $this->toSanitizeData = new ToSanitizeData($this->object);
        $this->toValidatables = new ToValidatables;
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

        $reflections = $class->getProperties();

        foreach ($reflections as $reflection) {
            if ($prop = $this->createPropAttributeFromReflectionProperty(
                $class->getName(),
                $reflection,
            )) {
                $result[] = $prop;
            }
        }

        return $result;
    }

    /**
     * create PropAttribute
     *
     * @param string $className
     * @param ReflectionProperty $reflection
     * @return PropAttribute|null
     */
    private function createPropAttributeFromReflectionProperty(
        string $className,
        ReflectionProperty $reflection,
    ): ?PropAttribute {
        /**
         * @var ExceptionFactory
         */
        $exception = null;

        $reflection->setAccessible(true);

        $propertyName = $reflection->getName();

        // get sanitizing property value
        $data = $this->toSanitizeData->byReflectionProperty($reflection);

        // get validatables
        $validatables = $this->toValidatables->byReflectionProperty($reflection);

        // get exception factory
        $exception = $this->toExceptionFactory->byReflectionProperty($reflection);

        return count($validatables) ? new PropAttribute(
            $className,
            $propertyName,
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
