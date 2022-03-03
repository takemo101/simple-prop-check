<?php

namespace Takemo101\SimplePropCheck\Preset\Numeric;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Max extends NumericValidatable
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
     * @param integer|float $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return $this->equal ? $this->max >= $data : $this->max > $data;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "[$:property] data is greater than :max"
            : "[$:property] data is greater than or equal to :max"
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
