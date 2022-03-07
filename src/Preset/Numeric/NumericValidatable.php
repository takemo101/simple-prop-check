<?php

namespace Takemo101\SimplePropCheck\Preset\Numeric;

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * @extends AbstractValidatable<integer|float|double>
 */
abstract class NumericValidatable extends AbstractValidatable
{
    /**
     * can it be verified
     *
     * @param mixed $data
     * @return bool
     */
    public function canVerified($data): bool
    {
        return is_integer($data) || is_float($data);
    }
}
