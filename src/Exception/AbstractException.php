<?php

namespace Takemo101\SimplePropCheck\Exception;

/**
 * abstract exception factory
 */
abstract class AbstractException implements ExceptionFactory
{
    /**
     * constructor
     */
    final public function __construct()
    {
        //
    }

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
