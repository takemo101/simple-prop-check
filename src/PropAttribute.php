<?php

namespace Takemo101\SimplePropCheck;

use InvalidArgumentException;
use Takemo101\SimplePropCheck\Exception\ExceptionFactory;

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
        private string $className,
        private string $propertyName,
        private mixed $data,
        private array $validatables,
        private ?ExceptionFactory $exceptionFactory,
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
     * @return Validatable<mixed>|null
     */
    public function verify(): ?Validatable
    {
        foreach ($this->validatables as $validatable) {

            if (!$validatable->canVerified($this->data)) {
                return null;
            }

            if (!$validatable->verify($this->data)) {
                return $validatable;
            }
        }

        return null;
    }
}
