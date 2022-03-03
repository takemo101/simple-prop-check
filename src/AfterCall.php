<?php

namespace Takemo101\SimplePropCheck;

use Attribute;

/**
 * specify the method to call after verification
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class AfterCall
{
    /**
     * constructor
     *
     * @param string $method
     */
    public function __construct(
        private string $method,
    ) {
        //
    }

    /**
     * get call method name
     *
     * @return string
     */
    public function getCallMethodName(): string
    {
        return $this->method;
    }
}
