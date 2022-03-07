<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * @extends AbstractValidatable<mixed[]>
 */
abstract class ArrayValidatable extends AbstractValidatable
{
    /**
     * can it be verified
     *
     * @param mixed $data
     * @return bool
     */
    public function canVerified($data): bool
    {
        return is_array($data);
    }
}
