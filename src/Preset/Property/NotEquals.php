<?php

namespace Takemo101\SimplePropCheck\Preset\Property;

use Attribute;
use Takemo101\SimplePropCheck\Support\ObjectProperties;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEquals extends PropertyValidatable
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
        return $properties->get($this->name) !== $data;
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] equals [:name]";
    }
}
