<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Unique extends ArrayValidatable
{
    /**
     * constructor
     *
     * @param string|null $message
     */
    public function __construct(
        private ?string $message = null,
    ) {
        //
    }

    /**
     * get validate the data of the property
     *
     * @param mixed[] $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        $counts = array_count_values($data);
        return max($counts) <= 1;
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[$:property] array data is not a unique";
    }
}
