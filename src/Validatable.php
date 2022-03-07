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
     * can it be verified
     *
     * @param mixed $data
     * @return bool
     */
    public function canVerified($data): bool;

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array;
}
