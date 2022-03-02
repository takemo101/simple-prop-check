<?php

namespace Takemo101\SimplePropCheck\Exception;

use Throwable;

/**
 * exception factory interface
 */
interface ExceptionFactory extends CopyInterface
{
    /**
     * factory method
     *
     * @param string $message
     * @return Throwable
     */
    public function factory(string $message): Throwable;
}
