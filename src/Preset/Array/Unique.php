<?php

namespace Takemo101\SimplePropCheck\Preset\Array;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Unique extends ArrayValidatable
{
    /**
     * constructor
     *
     * @param boolean $strict
     * @param string|null $message
     */
    public function __construct(
        private readonly bool $strict = false,
        private readonly ?string $message = null,
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
        $list = [];

        foreach ($data as $value) {
            if (array_search($value, $list, $this->strict)) {
                return false;
            }

            $list[] = $value;
        }

        return true;
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] array data is not a unique";
    }
}
