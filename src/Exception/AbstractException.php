<?php

namespace Takemo101\SimplePropCheck\Exception;

/**
 * abstract exception factory
 */
abstract class AbstractException implements ExceptionFactory
{
    /**
     * deep copy method
     *
     * @return static
     */
    public function copy(): static
    {
        return new static;
    }
}
