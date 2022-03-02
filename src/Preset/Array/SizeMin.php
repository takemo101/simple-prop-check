<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class SizeMin extends ArrayValidatable
{
    /**
     * constructor
     *
     * @param integer|float $min
     * @param boolean $equal
     * @param string|null $message
     */
    public function __construct(
        private int|float $min,
        private bool $equal = true,
        private ?string $message = null,
    ) {
        //
    }

    /**
     * get validate the data of the property
     *
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $size = count($data);
        return $this->equal ? $this->min <= $size : $this->min < $size;
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "data size is less than or equal to :min"
            : "data size is less than :min"
        );
    }

    /**
     * get validate parameters
     *
     * @return array<string,mixed>
     */
    public function parameters(): array
    {
        return [
            'min' => $this->min,
        ];
    }
}
