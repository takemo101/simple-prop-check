<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * @extends AbstractValidatable<mixed[]>
 */
abstract class ArrayValidatable extends AbstractValidatable
{
    /**
     * is valid data
     *
     * @param mixed $data
     * @return bool
     */
    public function isValid($data): bool
    {
        return is_array($data);
    }
}
