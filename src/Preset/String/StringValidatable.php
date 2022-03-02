<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * @extends AbstractValidatable<string>
 */
abstract class StringValidatable extends AbstractValidatable
{
    /**
     * is valid data
     *
     * @param mixed $data
     * @return bool
     */
    public function isValid($data): bool
    {
        return is_string($data);
    }
}
