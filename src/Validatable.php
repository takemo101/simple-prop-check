<?php

namespace Takemo101\SimplePropCheck;

/**
 * verify attribute interface
 *
 * @template T
 */
interface Validatable
{
    /**
     * validate the data of the property
     *
     * @param T $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool;

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string;

    /**
     * is valid data
     *
     * @param mixed $data
     * @return bool
     */
    public function isValidData($data): bool;

    /**
     * get validate parameters
     *
     * @return array<string,mixed>
     */
    public function parameters(): array;
}
