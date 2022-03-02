<?php

namespace Takemo101\SimplePropCheck\Exception;

use Takemo101\SimplePropCheck\PropCheckMarker;
use Throwable;

/**
 * exception factory interface
 */
interface ExceptionFactory extends CopyInterface, PropCheckMarker
{
    /**
     * factory method
     *
     * @param string $message
     * @return Throwable
     */
    public function factory(string $message): Throwable;
}
