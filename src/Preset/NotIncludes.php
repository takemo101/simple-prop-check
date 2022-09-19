<?php

namespace Takemo101\SimplePropCheck\Preset;

use Attribute;

/**
 * not includes attribute class
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class NotIncludes extends Includes
{
    /**
     * validate the data of the property
     *
     * @param mixed $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return !parent::verify($data);
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? '[:class::$:property] data is included';
    }
}
