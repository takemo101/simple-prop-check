<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxSize extends ArrayValidatable
{
    /**
     * constructor
     *
     * @param integer|float $max
     * @param boolean $equal
     * @param string|null $message
     */
    public function __construct(
        private int|float $max,
        private bool $equal = true,
        private ?string $message = null,
    ) {
        //
    }

    /**
     * validate the data of the property
     *
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $size = count($data);
        return $this->equal ? $this->max >= $size : $this->max > $size;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "[:class::$:property] data size is greater than :max"
            : "[:class::$:property] data size is greater than or equal to :max"
        );
    }

    /**
     * get validate placeholders
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            'max' => $this->max,
        ];
    }
}
