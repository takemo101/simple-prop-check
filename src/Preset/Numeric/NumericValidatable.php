<?php

namespace Takemo101\SimplePropCheck\Preset\Numeric;

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * @extends AbstractValidatable<integer|float|double>
 */
abstract class NumericValidatable extends AbstractValidatable
{
    /**
     * is valid data
     *
     * @param mixed $data
     * @return bool
     */
    public function isValid($data): bool
    {
        return is_integer($data) || is_float($data);
    }
}
