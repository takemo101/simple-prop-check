<?php

namespace Takemo101\SimplePropCheck\Preset\Property;

use Attribute;
use Takemo101\SimplePropCheck\Support\ObjectProperties;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEquals extends PropertyValidatable
{
    /**
     * validate the data of the property
     *
     * @param mixed $data
     * @param ObjectProperties $properties
     * @return boolean returns true if the data is OK
     */
    public function verifyWithProperties($data, ObjectProperties $properties): bool
    {
        return $properties->find($this->name) !== $data;
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
