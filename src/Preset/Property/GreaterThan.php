<?php

namespace Takemo101\SimplePropCheck\Preset\Property;

use Attribute;
use Takemo101\SimplePropCheck\Support\ObjectProperties;

#[Attribute(Attribute::TARGET_PROPERTY)]
class GreaterThan extends PropertyValidatable
{
    /**
     * verify by comparing properties
     *
     * @param mixed $data
     * @param ObjectProperties $properties
     * @return boolean returns true if the data is OK
     */
    public function compare($data, ObjectProperties $properties): bool
    {
        return $data > $properties->get($this->name);
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] is not greater than [:name]";
    }
}
