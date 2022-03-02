<?php

namespace Takemo101\SimplePropCheck\Exception;

use DomainException;
use Throwable;
use Attribute;

/**
 * default exception factory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Exception extends AbstractException
{
    /**
     * factory method
     *
     * @param string $message
     * @return Throwable
     */
    public function factory(string $message): Throwable
    {
        return new DomainException("property data error: {$message}");
    }
}
