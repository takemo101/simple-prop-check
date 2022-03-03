<?php

namespace Takemo101\SimplePropCheck\Preset\Numeric;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Negative extends NumericValidatable
{
    /**
     * constructor
     *
     * @param boolean $equal
     * @param string|null $message
     */
    public function __construct(
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
        return $this->equal ? 0 >= $data : 0 > $data;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "[:class::$:property] data is not a negative number including zero"
            : "[:class::$:property] data is not a negative number"
        );
    }
}
