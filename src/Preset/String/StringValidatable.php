<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * @extends AbstractValidatable<string>
 */
abstract class StringValidatable extends AbstractValidatable
{
    /**
     * can it be verified
     *
     * @param mixed $data
     * @return bool
     */
    public function canVerified($data): bool
    {
        return is_string($data);
    }
}
