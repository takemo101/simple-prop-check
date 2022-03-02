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
    public function isValidData($data): bool
    {
        return true;
    }

    /**
     * get validate parameters
     *
     * @return array<string,mixed>
     */
    public function parameters(): array
    {
        return [
            //
        ];
    }
}
