<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class LengthMin extends StringValidatable
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
     * @param string $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $length = mb_strlen($data);
        return $this->equal ? $this->min <= $length : $this->min < $length;
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? ($this->equal
            ? "data character length is less than or equal to :min"
            : "data character length is less than :min"
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
