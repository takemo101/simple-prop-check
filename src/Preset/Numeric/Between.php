<?php

namespace Takemo101\SimplePropCheck\Preset\Numeric;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Between extends NumericValidatable
{

    /**
     * constructor
     *
     * @param integer|float $min
     * @param integer|float $max
     * @param string|null $message
     */
    public function __construct(
        private int|float $min,
        private int|float $max,
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
        return $this->min <= $data && $this->max >= $data;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "data is not between :min and :max";
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
            'max' => $this->max,
        ];
    }
}
