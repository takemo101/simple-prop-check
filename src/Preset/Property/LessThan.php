<?php

namespace Takemo101\SimplePropCheck\Preset\Property;

use Attribute;
use Takemo101\SimplePropCheck\Support\ObjectProperties;

#[Attribute(Attribute::TARGET_PROPERTY)]
class LessThan extends PropertyValidatable
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
        return $data < $properties->find($this->name);
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] is not less than [:name]";
    }
}
