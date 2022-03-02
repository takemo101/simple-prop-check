<?php

namespace Takemo101\SimplePropCheck\Preset;

use Takemo101\SimplePropCheck\AbstractValidatable;
use Attribute;

/**
 * @extends AbstractValidatable<mixed>
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class NotEmpty extends AbstractValidatable
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
     * validate the data of the property
     *
     * @param mixed $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return !empty($data);
    }

    /**
     * get verification fraudulent message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? 'data is empty';
    }
}
