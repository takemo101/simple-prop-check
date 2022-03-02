<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class LengthBetween extends StringValidatable
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
     * @param string $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $length = mb_strlen($data);
        return $this->min <= $length && $this->max >= $length;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "character length of the data is not between :min and :max";
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
            'max' => $this->max,
        ];
    }
}
