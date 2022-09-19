<?php

namespace Takemo101\SimplePropCheck\Support;

use InvalidArgumentException;
use ReflectionClass;

/**
 * target object property collection
 */
final class ObjectProperties
{
    /**
     * @var array<string,mixed>
     */
    private readonly array $properties;

    /**
     * constructor
     *
     * @param array<string,mixed> $properties
     */
    public function __construct(
        array $properties,
    ) {
        /** @var array<string,mixed> */
        $props = [];

        foreach ($properties as $name => $value) {
            $props[$name] = $value;
        }

        $this->properties = $props;
    }

    /**
     * find by property name
     *
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function find(string $name): mixed
    {
        if (!array_key_exists($name, $this->properties)) {
            throw new InvalidArgumentException("property not found: {$name}");
        }

        return $this->properties[$name];
    }

    /**
     * to PropAttribute array
     *
     * @param object $object
     * @return self
     */
    public static function fromObject(object $object): self
    {
        /** @var array<string,mixed> */
        $props = [];

        $class = new ReflectionClass($object);

        $reflections = $class->getProperties();

        foreach ($reflections as $reflection) {
            $props[$reflection->getName()] = $reflection->getValue($object);
        }

        return new self($props);
    }
}
