<?php

namespace Takemo101\SimplePropCheck\Exception;

interface CopyInterface
{
    /**
     * deep copy method
     *
     * @return static
     */
    public function copy(): static;
}
