<?php

namespace Takemo101\SimplePropCheck\Sanitize\String;

use Takemo101\SimplePropCheck\Sanitizable;
use Attribute;

/**
 * sanitize class
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Replace implements Sanitizable
{
    /**
     * constructor
     *
     * @param string[]|string $search
     * @param string[]|string $replace
     */
    public function __construct(
        private array|string $search,
        private array|string $replace,
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
            return str_replace($this->search, $this->replace, $data);
        }

        return $data;
    }
}
