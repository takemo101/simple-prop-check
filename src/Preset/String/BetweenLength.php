<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BetweenLength extends StringValidatable
{

    /**
     * constructor
     *
     * @param integer|float $min
     * @param integer|float $max
     * @param string|null $message
     */
    public function __construct(
        private readonly int|float $min,
        private readonly int|float $max,
        private readonly ?string $message = null,
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
        return $this->message ?? "character length of the [:class::$:property] data is not between :min and :max";
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
