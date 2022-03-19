<?php

namespace Takemo101\SimplePropCheck\Sanitize\String;

use Takemo101\SimplePropCheck\Sanitizable;
use Attribute;

/**
 * sanitize class
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class LTrim implements Sanitizable
{
    /**
     * constructor
     *
     * @param string|null $characters
     */
    public function __construct(
        private ?string $characters = null,
    ) {
    }

    /**
     * sanitize the data of the property
     *
     * @param mixed $data
     * @return mixed
     */
    public function sanitize(mixed $data): mixed
    {
        if (is_string($data)) {
            return $this->characters
                ? ltrim($data, $this->characters)
                : ltrim($data);
        }

        return $data;
    }
}
