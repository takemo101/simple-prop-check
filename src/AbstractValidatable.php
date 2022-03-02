<?php

namespace Takemo101\SimplePropCheck;

/**
 * verify attribute abstract class
 *
 * @template T
 * @implements Validatable<T>
 */
abstract class AbstractValidatable implements Validatable
{
    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return 'data is invalid';
    }

    /**
     * is valid data
     *
     * @param mixed $data
     * @return bool
     */
    public function isValid($data): bool
    {
        return true;
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            //
        ];
    }
}