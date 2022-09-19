<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Support\ObjectProperties;

/**
 * verify with properties attribute interface
 *
 * @template T
 */
interface WithProperties
{
    /**
     * validate the data of the property
     * with property collection
     *
     * @param T $data
     * @param ObjectProperties $properties
     * @return boolean returns true if the data is OK
     */
    public function verifyWithProperties($data, ObjectProperties $properties): bool;
}
