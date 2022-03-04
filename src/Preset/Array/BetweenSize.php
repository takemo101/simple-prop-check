<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BetweenSize extends ArrayValidatable
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
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $size = count($data);
        return $this->min <= $size && $this->max >= $size;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] data size is not between :min and :max";
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
