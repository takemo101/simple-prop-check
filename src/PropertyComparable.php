<?php

namespace Takemo101\SimplePropCheck;

use Takemo101\SimplePropCheck\Support\ObjectProperties;

/**
 * verify by comparing properties attribute interface
 *
 * @template T
 */
interface PropertyComparable
{
    /**
     * verify by comparing properties
     *
     * @param T $data
     * @param ObjectProperties $properties
     * @return boolean returns true if the data is OK
     */
    public function compare($data, ObjectProperties $properties): bool;
}
