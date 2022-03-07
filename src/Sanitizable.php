<?php

namespace Takemo101\SimplePropCheck;

/**
 * sanitize interface
 */
interface Sanitizable
{
    /**
     * sanitize the data of the property
     *
     * @param mixed $data
     * @return mixed
     */
    public function sanitize(mixed $data): mixed;
}
