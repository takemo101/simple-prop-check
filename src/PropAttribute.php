<?php

namespace Takemo101\SimplePropCheck;

use InvalidArgumentException;
use Takemo101\SimplePropCheck\Exception\ExceptionFactory;
use Takemo101\SimplePropCheck\Support\ObjectProperties;

/**
 * property attribute data class
 */
final class PropAttribute
{
    /**
     * constructor
     *
     * @param string $className
     * @param string $propertyName
     * @param mixed $data
     * @param Validatable<mixed>[] $validatables
     * @param ExceptionFactory|null $exceptionFactory
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly string $className,
        private readonly string $propertyName,
        private readonly mixed $data,
        private readonly array $validatables,
        private readonly ?ExceptionFactory $exceptionFactory,
    ) {
        if (!count($validatables)) {
            throw new InvalidArgumentException('constructor argument error: validatables is empty');
        }
    }

    /**
     * get property name
     *
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * get class name
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * get data
     *
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * get validatable array
     *
     * @return Validatable<mixed>[]
     */
    public function getValidatables(): array
    {
        return $this->validatables;
    }

    /**
     * get exception factory
     *
     * @return ExceptionFactory|null
     */
    public function getExceptionFactory(): ?ExceptionFactory
    {
        return $this->exceptionFactory;
    }

    /**
     * verify
     *
     * @param ObjectProperties $properties
     * @return Validatable<mixed>|null
     */
    public function verify(ObjectProperties $properties): ?Validatable
    {
        foreach ($this->validatables as $validatable) {

            if (!$validatable->canVerified($this->data)) {
                return null;
            }

            if (!$validatable->verify($this->data)) {
                return $validatable;
            }

            if (
                ($validatable instanceof PropertyComparable) &&
                !$validatable->compare($this->data, $properties)
            ) {
                return $validatable;
            }
        }

        return null;
    }
}
