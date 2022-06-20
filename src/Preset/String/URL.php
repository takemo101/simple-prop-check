<?php

namespace Takemo101\SimplePropCheck\Preset\String;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class URL extends StringValidatable
{
    /**
     * constructor
     *
     * @param string|null $message
     */
    public function __construct(
        private readonly ?string $message = null,
    ) {
        //
    }

    /**
     * get validate the data of the property
     *
     * @param string $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return (bool)filter_var($data, FILTER_VALIDATE_URL);
    }

    /**
     * verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? "[:class::$:property] data is data is not a url";
    }
}
