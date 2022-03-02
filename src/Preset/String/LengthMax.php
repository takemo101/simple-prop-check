<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class LengthMax extends StringValidatable
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
     * @param string $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $length = mb_strlen($data);
        return $this->equal ? $this->max >= $length : $this->max > $length;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "[$:property] data character length is greater than :max"
            : "[$:property] data character length is greater than or equal to :max"
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
