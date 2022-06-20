<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MinLength extends StringValidatable
{
    /**
     * constructor
     *
     * @param integer|float $min
     * @param boolean $equal
     * @param string|null $message
     */
    public function __construct(
        private readonly int|float $min,
        private readonly bool $equal = true,
        private readonly ?string $message = null,
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
            ? "[:class::$:property] data character length is less than or equal to :min"
            : "[:class::$:property] data character length is less than :min"
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
