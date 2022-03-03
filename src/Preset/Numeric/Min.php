<?php

namespace Takemo101\SimplePropCheck\Preset\Numeric;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Min extends NumericValidatable
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
     * @param integer|float $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return $this->equal ? $this->min <= $data : $this->min < $data;
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "[$:property] data is less than or equal to :min"
            : "[$:property] data is less than :min"
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
            'min' => $this->min,
        ];
    }
}
